<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Debug: Log what's being received
        Log::info('Profile update attempt', [
            'user_id' => $user->id,
            'has_photo' => $request->hasFile('profile_photo'),
            'photo_details' => $request->hasFile('profile_photo') ? [
                'name' => $request->file('profile_photo')->getClientOriginalName(),
                'size' => $request->file('profile_photo')->getSize(),
                'mime' => $request->file('profile_photo')->getMimeType(),
            ] : null,
            'username' => $request->get('username'),
            'all_data' => $request->all()
        ]);
        
        // Manejar la subida de foto de perfil
        if ($request->hasFile('profile_photo')) {
            try {
                // Eliminar foto anterior si existe
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                    Log::info('Previous photo deleted', ['path' => $user->profile_photo_path]);
                }
                
                // Subir nueva foto
                $path = $request->file('profile_photo')->store('profiles', 'public');
                $user->profile_photo_path = $path;
                Log::info('New photo uploaded', ['path' => $path]);
            } catch (\Exception $e) {
                Log::error('Photo upload failed', ['error' => $e->getMessage()]);
                return back()->withErrors(['profile_photo' => 'Error al subir la foto: ' . $e->getMessage()]);
            }
        }
        
        // Actualizar otros campos
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        try {
            $user->save();
            Log::info('Profile updated successfully', ['user_id' => $user->id]);
        } catch (\Exception $e) {
            Log::error('Profile save failed', ['error' => $e->getMessage()]);
            return back()->withErrors(['general' => 'Error al guardar el perfil: ' . $e->getMessage()]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's profile photo.
     */
    public function deleteProfilePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
