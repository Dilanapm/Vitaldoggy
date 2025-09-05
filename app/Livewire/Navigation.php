<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Navigation extends Component
{
    public $showMobileMenu = false;
    public $showProfileDropdown = false;
    public $theme = 'light';
    
    // Para futuras notificaciones
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        // Inicializar tema desde localStorage se hará en JavaScript
        $this->theme = 'light';
        
        // Cargar notificaciones del usuario si está autenticado
        if (Auth::check()) {
            $this->loadNotifications();
        }
    }

    public function toggleMobileMenu()
    {
        $this->showMobileMenu = !$this->showMobileMenu;
    }

    public function toggleProfileDropdown()
    {
        $this->showProfileDropdown = !$this->showProfileDropdown;
    }

    public function closeDropdowns()
    {
        $this->showProfileDropdown = false;
    }

    public function toggleTheme()
    {
        $this->theme = $this->theme === 'light' ? 'dark' : 'light';
        $this->dispatch('theme-changed', theme: $this->theme);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        
        return redirect('/');
    }

    private function loadNotifications()
    {
        // Aquí cargarás las notificaciones reales más adelante
        // Por ahora simulamos algunas
        $this->notifications = [
            // ['id' => 1, 'message' => 'Nueva solicitud de adopción', 'read' => false],
            // ['id' => 2, 'message' => 'Tu adopción fue aprobada', 'read' => false],
        ];
        
        $this->unreadCount = collect($this->notifications)->where('read', false)->count();
    }

    // Método para futuras notificaciones en tiempo real
    public function markAsRead($notificationId)
    {
        // Marcar notificación como leída
        foreach ($this->notifications as &$notification) {
            if ($notification['id'] == $notificationId) {
                $notification['read'] = true;
                break;
            }
        }
        
        $this->unreadCount = collect($this->notifications)->where('read', false)->count();
    }

    // Helper function para determinar si un enlace está activo
    public function isActiveRoute($routes)
    {
        if (is_string($routes)) {
            $routes = [$routes];
        }
        
        foreach ($routes as $route) {
            if (request()->routeIs($route) || request()->is($route)) {
                return true;
            }
        }
        
        return false;
    }

    // Helper function para verificar si el usuario es admin
    public function isAdmin()
    {
        return Auth::check() && Auth::user()->hasRole('admin');
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
