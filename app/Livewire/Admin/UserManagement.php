<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $statusFilter = '';
    
    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'userStatusToggled' => 'refreshComponent',
        'userDeleted' => 'refreshComponent'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function toggleUserStatus($userId)
    {
        try {
            $user = User::findOrFail($userId);
            
            $user->update([
                'is_active' => !$user->is_active
            ]);

            $status = $user->is_active ? 'activado' : 'desactivado';
            
            $this->dispatch('show-alert', 
                type: 'success',
                title: '¡Éxito!',
                message: "Usuario {$status} correctamente"
            );

            Log::info('User status toggled', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'new_status' => $user->is_active ? 'active' : 'inactive',
                'changed_by' => Auth::user()->name
            ]);

        } catch (\Exception $e) {
            Log::error('Error toggling user status', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('show-alert',
                type: 'error',
                title: 'Error',
                message: 'No se pudo cambiar el estado del usuario'
            );
        }
    }

    public function confirmToggleStatus($userId, $userName, $currentStatus)
    {
        // Este método ya no es necesario, se maneja desde JavaScript
        $this->toggleUserStatus($userId);
    }

    public function refreshComponent()
    {
        // Forzar re-renderizado del componente
        $this->render();
    }

    public function render()
    {
        $query = User::query()->with(['shelter']);

        // Aplicar filtros
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('username', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter) {
            $query->where('role', $this->roleFilter);
        }

        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter == 'active');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calcular estadísticas
        $userStats = [
            'by_status' => [
                'active' => User::where('is_active', true)->count(),
                'inactive' => User::where('is_active', false)->count(),
            ],
            'by_role' => [
                'admin' => User::where('role', 'admin')->count(),
                'caretaker' => User::where('role', 'caretaker')->count(),
                'adopter' => User::where('role', 'adopter')->count(),
            ]
        ];

        return view('livewire.admin.user-management', compact('users', 'userStats'));
    }
}
