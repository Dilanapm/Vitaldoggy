<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Los administradores pueden ver cualquier usuario
        if ($user->hasRole('admin')) {
            return true;
        }

        // Los usuarios pueden ver su propio perfil
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Los administradores pueden actualizar cualquier usuario
        if ($user->hasRole('admin')) {
            return true;
        }

        // Los usuarios pueden actualizar su propio perfil (pero no roles)
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can manage roles for the model.
     */
    public function manageRoles(User $user, User $model): bool
    {
        // Solo los administradores pueden gestionar roles
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Los administradores no pueden modificar sus propios roles
        if ($user->id === $model->id) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can assign specific roles.
     */
    public function assignRole(User $user, User $model, string $role): bool
    {
        // Solo los administradores pueden asignar roles
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Lista de roles principales que pueden ser asignados por administradores
        $assignableRoles = ['user', 'caretaker', 'admin'];
        
        return in_array($role, $assignableRoles);
    }

    /**
     * Determine whether the user can remove specific roles.
     */
    public function removeRole(User $user, User $model, string $role): bool
    {
        // Solo los administradores pueden remover roles
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Los administradores no pueden remover roles de sí mismos
        if ($user->id === $model->id) {
            return false;
        }

        // Solo permitir cambiar roles principales
        return in_array($role, ['user', 'caretaker', 'admin']);
    }

    /**
     * Determine whether the user can manage achievements.
     */
    public function manageAchievements(User $user, User $model): bool
    {
        // Solo los administradores pueden gestionar logros manualmente
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Los administradores no pueden modificar sus propios logros
        return $user->id !== $model->id;
    }

    /**
     * Determine whether the user can change status (active/inactive).
     */
    public function changeStatus(User $user, User $model): bool
    {
        // Solo los administradores pueden cambiar estados
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Los administradores no pueden cambiar su propio estado
        return $user->id !== $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Solo los administradores pueden eliminar usuarios
        if (!$user->hasRole('admin')) {
            return false;
        }

        // Los administradores no pueden eliminarse a sí mismos
        return $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('admin') && $user->id !== $model->id;
    }
}
