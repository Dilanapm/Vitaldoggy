<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileUpdate extends Component
{
    use WithFileUploads;

    public $name;
    public $username;
    public $email;
    public $phone;
    public $address;
    public $profile_photo;
    public $current_photo_path;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:2048',
            ],
        ];
    }

    protected $messages = [
        'username.unique' => 'Este nombre de usuario ya está en uso.',
        'username.regex' => 'El nombre de usuario solo puede contener letras, números y guiones bajos.',
        'email.unique' => 'Este email ya está en uso.',
        'profile_photo.image' => 'El archivo debe ser una imagen.',
        'profile_photo.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png, gif.',
        'profile_photo.max' => 'La imagen no debe exceder los 2MB.',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->current_photo_path = $user->profile_photo_path;
    }

    public function updateProfile()
    {
        $this->validate();

        $user = Auth::user();

        // Manejar subida de foto
        if ($this->profile_photo) {
            // Eliminar foto anterior si existe
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            // Subir nueva foto
            $path = $this->profile_photo->store('profiles', 'public');
            $user->profile_photo_path = $path;
        }

        // Actualizar otros campos
        $user->update([
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        if ($this->profile_photo) {
            $user->save(); // Guardar la foto si se subió una nueva
        }

        // Reset del archivo para evitar problemas
        $this->reset('profile_photo');
        $this->current_photo_path = $user->fresh()->profile_photo_path;

        session()->flash('status', 'profile-updated');
        $this->dispatch('profile-updated');
    }

    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
            
            $this->current_photo_path = null;
            session()->flash('status', 'photo-deleted');
        }
    }

    public function render()
    {
        return view('livewire.profile-update');
    }
}
