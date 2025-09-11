<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shelter;
use App\Models\Caretaker;
use App\Models\Pet;
use App\Models\AdoptionApplication;
use App\Http\Requests\StoreShelterRequest;
use App\Http\Requests\UpdateShelterRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Panel principal de administrador con estadísticas
     */
    public function dashboard(): View
    {
        $stats = [
            // Usuarios
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            
            // Refugios/Shelters
            'total_shelters' => Shelter::count(),
            'active_shelters' => Shelter::where('status', 'active')->count(),
            'inactive_shelters' => Shelter::where('status', 'inactive')->count(),
            
            // Cuidadores
            'total_caretakers' => Caretaker::count(),
            'caretakers_this_month' => Caretaker::whereMonth('created_at', now()->month)->count(),
            
            // Mascotas
            'total_pets' => Pet::count(),
            'available_pets' => Pet::where('adoption_status', 'available')->count(),
            'adopted_pets' => Pet::where('adoption_status', 'adopted')->count(),
            'pending_pets' => Pet::where('adoption_status', 'pending')->count(),
            
            // Adopciones
            'total_applications' => AdoptionApplication::count(),
            'pending_applications' => AdoptionApplication::where('status', 'pending')->count(),
            'approved_applications' => AdoptionApplication::where('status', 'approved')->count(),
            'applications_this_month' => AdoptionApplication::whereMonth('created_at', now()->month)->count(),
        ];

        // Datos para gráficos
        $monthlyAdoptions = $this->getMonthlyAdoptionStats();
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact('stats', 'monthlyAdoptions', 'recentActivities'));
    }

    /**
     * Gestión de usuarios
     */
    public function users(): View
    {
        return view('admin.users.index');
    }

    /**
     * Crear nuevo usuario
     */
    public function createUser(): View
    {
        $shelters = Shelter::where('status', 'active')->get();
        return view('admin.users.create', compact('shelters'));
    }

    /**
     * Guardar nuevo usuario
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,caretaker,donor,admin',
            'shelter_id' => 'nullable|exists:shelters,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'roles' => json_encode([$request->role]), // Nuevo sistema de roles JSON
            'shelter_id' => $request->shelter_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(), // Admin puede crear usuarios verificados
        ]);

        // Si es caretaker, crear registro en tabla caretakers
        if ($request->role === 'caretaker' && $request->shelter_id) {
            Caretaker::create([
                'user_id' => $user->id,
                'shelter_id' => $request->shelter_id,
                'position' => 'Cuidador',
                'start_date' => now(),
                'phone' => $request->phone,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Alternar estado activo/inactivo de usuario
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$status} exitosamente.");
    }

    /**
     * Gestión de refugios
     */
    public function shelters(): View
    {
        $shelters = Shelter::withCount(['pets', 'caretakers'])
            ->latest()
            ->get();

        return view('admin.shelters.index', compact('shelters'));
    }

    /**
     * Crear nuevo refugio
     */
    public function createShelter(): View
    {
        return view('admin.shelters.create');
    }

    /**
     * Guardar nuevo refugio
     */
    public function storeShelter(StoreShelterRequest $request)
    {
        $data = $request->validated();

        // Manejar subida de imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('shelters', 'public');
            $data['image_path'] = $imagePath;
        }

        Shelter::create($data);

        return redirect()->route('admin.shelters.index')->with('success', 'Refugio creado exitosamente.');
    }

    /**
     * Estadísticas de adopciones mensuales
     */
    private function getMonthlyAdoptionStats(): array
    {
        return AdoptionApplication::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', 'approved')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
    }

    /**
     * Actividades recientes para el dashboard
     */
    private function getRecentActivities(): array
    {
        $activities = collect();

        // Usuarios recientes
        $recentUsers = User::latest()->take(3)->get();
        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user_registered',
                'description' => "Nuevo usuario registrado: {$user->name}",
                'date' => $user->created_at,
                'icon' => '👤',
                'color' => 'blue'
            ]);
        }

        // Solicitudes recientes
        $recentApplications = AdoptionApplication::with(['user', 'pet'])
            ->latest()->take(3)->get();
        foreach ($recentApplications as $app) {
            $activities->push([
                'type' => 'adoption_application',
                'description' => "{$app->user->name} solicitó adoptar a {$app->pet->name}",
                'date' => $app->created_at,
                'icon' => '🐕',
                'color' => 'green'
            ]);
        }

        return $activities->sortByDesc('date')->take(6)->values()->all();
    }

    /**
     * Show the form for editing a user
     */
    public function editUser(User $user): View
    {
        $shelters = Shelter::where('status', 'active')->get();
        return view('admin.users.edit', compact('user', 'shelters'));
    }

    /**
     * Update the specified user
     */
    public function updateUser(Request $request, User $user)
    {
        // Verificar autorización para actualizar usuario
        Gate::authorize('update', $user);

        // Validación dinámica según el rol
        $rules = [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $user->id . '|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'sometimes|string|in:user,admin,caretaker',
        ];

        // Si el rol es caretaker, shelter_id es requerido
        if ($request->role === 'caretaker') {
            $rules['shelter_id'] = 'required|exists:shelters,id';
        } else {
            $rules['shelter_id'] = 'nullable|exists:shelters,id';
        }

        $request->validate($rules);

        $data = $request->only(['name', 'username', 'email', 'phone', 'address']);
        
        // Manejar cambio de estado solo si tiene autorización
        if ($request->has('status') && Gate::allows('changeStatus', $user)) {
            $data['is_active'] = $request->status === 'active';
        }
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        // Manejar cambio de rol solo si tiene autorización
        if ($request->has('role') && Gate::allows('manageRoles', $user)) {
            $newRole = $request->role;
            
            // Validar que el usuario puede asignar este rol
            if (!Gate::forUser(Auth::user())->allows('assignRole', [$user, $newRole])) {
                return back()->withErrors([
                    'role' => "No tienes permisos para asignar el rol: {$newRole}"
                ]);
            }
            
            $data['role'] = $newRole;
            
            // Manejar shelter_id según el rol
            if ($newRole === 'caretaker') {
                // Para cuidadores, shelter_id es requerido
                if (!$request->shelter_id) {
                    return back()->withErrors([
                        'shelter_id' => 'Los cuidadores deben estar asignados a un refugio'
                    ]);
                }
                $data['shelter_id'] = $request->shelter_id;
            } else {
                // Para otros roles, remover asignación de refugio
                $data['shelter_id'] = null;
            }
        } elseif ($request->has('shelter_id') && $user->role === 'caretaker') {
            // Si no cambia el rol pero es cuidador, permitir cambiar refugio
            $data['shelter_id'] = $request->shelter_id;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Show the form for editing a shelter
     */
    public function editShelter(Shelter $shelter): View
    {
        $shelter->loadCount(['pets', 'caretakers']);
        return view('admin.shelters.edit', compact('shelter'));
    }

    /**
     * Update the specified shelter
     */
    public function updateShelter(UpdateShelterRequest $request, Shelter $shelter)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($shelter->image_path) {
                Storage::disk('public')->delete($shelter->image_path);
            }

            $imagePath = $request->file('image')->store('shelters', 'public');
            $data['image_path'] = $imagePath;
        }

        $shelter->update($data);

        return redirect()->route('admin.shelters.index')->with('success', 'Refugio actualizado correctamente.');
    }

    /**
     * Toggle shelter status
     */
    public function toggleShelterStatus(Shelter $shelter)
    {
        $shelter->update([
            'status' => $shelter->status === 'active' ? 'inactive' : 'active'
        ]);

        return redirect()->back()->with('success', 'Estado del refugio actualizado correctamente.');
    }

    /**
     * Remove the specified shelter from storage
     */
    public function destroyShelter(Shelter $shelter)
    {
        // Delete image if exists
        if ($shelter->image_path) {
            $imagePath = storage_path('app/public/shelters/' . $shelter->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $shelter->delete();

        return redirect()->route('admin.shelters.index')->with('success', 'Refugio eliminado correctamente.');
    }
}
