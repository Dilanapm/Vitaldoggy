<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    /**
     * Show the adoption form for a specific pet
     */
    public function create(Pet $pet)
    {
        // Verificar que el usuario este autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Debes iniciar sesión para solicitar una adopción.');
        }

        // Verificar que la mascota esté disponible
        if ($pet->adoption_status !== 'available') {
            return redirect()->route('pets.index')
                ->with('error', 'Esta mascota ya no está disponible para adopción.');
        }

        // Verificar si el usuario ya tiene una solicitud pendiente para esta mascota
        $existingApplication = AdoptionApplication::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return redirect()->route('pets.index')
                ->with('info', 'Ya tienes una solicitud pendiente para esta mascota.');
        }

        return view('adoption.create', compact('pet'));
    }

    /**
     * Show adoption applications for the authenticated user
     */
    public function index()
    {
        // Obtener solicitudes del usuario autenticado
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')
                ->with('message', 'Debes iniciar sesión para ver tus solicitudes.');
        }

        // Obtener solicitudes del usuario con relaciones
        $applications = AdoptionApplication::with(['pet.photos', 'documents'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('adoption.index', compact('applications'));
    }
}
