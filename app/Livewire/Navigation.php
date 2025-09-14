<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    // Helper function para verificar si el usuario es cuidador
    public function isCaretaker()
    {
        return Auth::check() && Auth::user()->hasRole('caretaker');
    }

    // Obtener texto del enlace de adopciones según el rol
    public function getPetsLinkText()
    {
        if ($this->isCaretaker()) {
            return 'Mis Mascotas';
        }
        return 'Adopciones';
    }

    // Obtener texto del enlace de refugios según el rol
    public function getSheltersLinkText()
    {
        if ($this->isCaretaker()) {
            return 'Mi Refugio';
        } elseif ($this->isAdmin()) {
            return 'Mis Refugios';
        }
        return 'Refugios';
    }

    // Obtener ruta de refugios según el rol
    public function getSheltersRoute()
    {
        if ($this->isCaretaker()) {
            // Cuidador va a la vista de su refugio específico
            $user = Auth::user();
            if ($user && $user->shelter_id) {
                return route('shelters.show', $user->shelter_id);
            }
        } elseif ($this->isAdmin()) {
            // Admin va al panel de administración de refugios
            return route('admin.shelters.index');
        }
        // Usuarios normales van al listado público general
        return route('shelters.index');
    }

    // Obtener información del refugio del cuidador
    public function getCaretakerShelter()
    {
        if ($this->isCaretaker()) {
            $user = Auth::user();
            if ($user && $user->shelter_id) {
                return $user->shelter;
            }
        }
        return null;
    }

    // Obtener ruta del logo según el rol del usuario
    public function getLogoRoute()
    {
        if (!Auth::check()) {
            // Usuario no autenticado va al home
            return route('home');
        }

        $user = Auth::user();
        
        if ($this->isAdmin()) {
            // Admin va a su dashboard
            return route('admin.dashboard');
        } elseif ($this->isCaretaker()) {
            // Cuidador va a su dashboard (puede ser el user.dashboard o uno específico)
            return route('caretaker.dashboard');
        } else {
            // Usuario normal va al home
            return route('home');
        }
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
