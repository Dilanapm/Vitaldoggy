<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver el listado público
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pet $pet): bool
    {
        // Todos los usuarios autenticados pueden ver detalles de mascotas
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Solo administradores y cuidadores pueden crear mascotas
        return in_array($user->role, ['admin', 'caretaker']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pet $pet): bool
    {
        // Administradores pueden editar cualquier mascota
        if ($user->role === 'admin') {
            return true;
        }

        // Cuidadores solo pueden editar mascotas de su refugio
        if ($user->role === 'caretaker') {
            // Verificar si el cuidador pertenece al mismo refugio que la mascota
            return $user->caretaker && 
                   $user->caretaker->shelter_id === $pet->shelter_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pet $pet): bool
    {
        // Solo administradores pueden eliminar mascotas (si se implementa eliminación)
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pet $pet): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pet $pet): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can manage adoption status (mark as adopted, change status).
     */
    public function manageAdoption(User $user, Pet $pet): bool
    {
        // Administradores pueden manejar adopciones de cualquier mascota
        if ($user->role === 'admin') {
            return true;
        }

        // Cuidadores solo pueden manejar adopciones de mascotas de su refugio
        if ($user->role === 'caretaker') {
            return $user->caretaker && 
                   $user->caretaker->shelter_id === $pet->shelter_id;
        }

        return false;
    }

    /**
     * Determine whether the user can toggle pet status (activate/deactivate).
     */
    public function toggleStatus(User $user, Pet $pet): bool
    {
        // Administradores pueden cambiar estado de cualquier mascota
        if ($user->role === 'admin') {
            return true;
        }

        // Cuidadores solo pueden cambiar estado de mascotas de su refugio
        if ($user->role === 'caretaker') {
            return $user->caretaker && 
                   $user->caretaker->shelter_id === $pet->shelter_id;
        }

        return false;
    }

    /**
     * Determine whether the user can view adoption applications for this pet.
     */
    public function viewApplications(User $user, Pet $pet): bool
    {
        // Administradores pueden ver solicitudes de cualquier mascota
        if ($user->role === 'admin') {
            return true;
        }

        // Cuidadores solo pueden ver solicitudes de mascotas de su refugio
        if ($user->role === 'caretaker') {
            return $user->caretaker && 
                   $user->caretaker->shelter_id === $pet->shelter_id;
        }

        return false;
    }

    /**
     * Determine whether the user can apply for adoption of this pet.
     */
    public function applyForAdoption(User $user, Pet $pet): bool
    {
        // Los administradores y cuidadores NO pueden adoptar mascotas
        if (in_array($user->role, ['admin', 'caretaker'])) {
            return false;
        }

        // Solo usuarios regulares pueden solicitar adopción
        // y la mascota debe estar disponible
        return $user->role === 'user' && $pet->adoption_status === 'available';
    }
}
