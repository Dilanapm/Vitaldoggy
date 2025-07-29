<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class CaretakerController extends Controller
{
    /**
     * Display a listing of the caretakers.
     */
    public function index()
    {
        // Si el usuario es admin, puede ver todos los cuidadores
        if (Auth::user()->role === 'admin') {
            $caretakers = User::where('role', 'caretaker')->with('shelter')->paginate(10);
            return view('admin.caretakers.index', compact('caretakers'));
        }
        
        // Si el usuario es cuidador, solo puede ver cuidadores de su mismo albergue
        if (Auth::user()->role === 'caretaker') {
            $caretakers = User::where('role', 'caretaker')
                ->where('shelter_id', Auth::user()->shelter_id)
                ->with('shelter')
                ->paginate(10);
            return view('caretaker.caretakers.index', compact('caretakers'));
        }
        
        // Si no es ninguno de los anteriores, redirigir al dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Show the form for creating a new caretaker.
     */
    public function create()
    {
        // Si el usuario es admin, puede asignar cuidadores a cualquier albergue
        if (Auth::user()->role === 'admin') {
            $shelters = Shelter::where('is_active', true)->get();
            return view('admin.caretakers.create', compact('shelters'));
        }
        
        // Si el usuario es cuidador, solo puede asignar a su mismo albergue
        if (Auth::user()->role === 'caretaker') {
            $shelter = Auth::user()->shelter;
            return view('caretaker.caretakers.create', compact('shelter'));
        }
        
        // Si no es ninguno de los anteriores, redirigir al dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created caretaker in storage.
     */
    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'shelter_id' => ['required', 'exists:shelters,id'],
        ]);
        
        // Verificar que el usuario tenga permisos para crear cuidadores en este albergue
        if (Auth::user()->role === 'caretaker' && Auth::user()->shelter_id != $request->shelter_id) {
            return back()->withErrors([
                'shelter_id' => 'No tienes permisos para crear cuidadores en otros albergues.'
            ]);
        }
        
        // Crear el nuevo cuidador
        $caretaker = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'caretaker',
            'shelter_id' => $request->shelter_id,
            'is_active' => true,
            'phone' => $request->phone,
            'address' => $request->address,
            'email_verified_at' => now(), // Auto-verificar el email para simplificar
        ]);
        
        // Redirigir según el rol del usuario
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.caretakers.index')
                ->with('success', 'Cuidador creado exitosamente.');
        } else {
            return redirect()->route('caretaker.caretakers.index')
                ->with('success', 'Cuidador creado exitosamente.');
        }
    }

    /**
     * Display the specified caretaker.
     */
    public function show(User $caretaker)
    {
        // Verificar que sea un cuidador
        if ($caretaker->role !== 'caretaker') {
            abort(404);
        }
        
        // Verificar permisos
        if (Auth::user()->role === 'caretaker' && Auth::user()->shelter_id !== $caretaker->shelter_id) {
            abort(403, 'No tienes permisos para ver este cuidador.');
        }
        
        // Mostrar vista según rol
        if (Auth::user()->role === 'admin') {
            return view('admin.caretakers.show', compact('caretaker'));
        } else {
            return view('caretaker.caretakers.show', compact('caretaker'));
        }
    }

    /**
     * Show the form for editing the specified caretaker.
     */
    public function edit(User $caretaker)
    {
        // Verificar que sea un cuidador
        if ($caretaker->role !== 'caretaker') {
            abort(404);
        }
        
        // Verificar permisos
        if (Auth::user()->role === 'caretaker' && Auth::user()->shelter_id !== $caretaker->shelter_id) {
            abort(403, 'No tienes permisos para editar este cuidador.');
        }
        
        // Para administradores, pueden cambiar el albergue
        if (Auth::user()->role === 'admin') {
            $shelters = Shelter::where('is_active', true)->get();
            return view('admin.caretakers.edit', compact('caretaker', 'shelters'));
        } else {
            return view('caretaker.caretakers.edit', compact('caretaker'));
        }
    }

    /**
     * Update the specified caretaker in storage.
     */
    public function update(Request $request, User $caretaker)
    {
        // Verificar que sea un cuidador
        if ($caretaker->role !== 'caretaker') {
            abort(404);
        }
        
        // Verificar permisos
        if (Auth::user()->role === 'caretaker' && Auth::user()->shelter_id !== $caretaker->shelter_id) {
            abort(403, 'No tienes permisos para actualizar este cuidador.');
        }
        
        // Validar datos
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ];
        
        // Si el email ha cambiado, validar que sea único
        if ($request->email !== $caretaker->email) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255'];
        }
        
        // Si se proporciona una contraseña, validarla
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }
        
        // Solo los administradores pueden cambiar el albergue
        if (Auth::user()->role === 'admin') {
            $rules['shelter_id'] = ['required', 'exists:shelters,id'];
        }
        
        $request->validate($rules);
        
        // Actualizar el cuidador
        $caretaker->name = $request->name;
        $caretaker->email = $request->email;
        $caretaker->phone = $request->phone;
        $caretaker->address = $request->address;
        
        if ($request->filled('password')) {
            $caretaker->password = Hash::make($request->password);
        }
        
        if (Auth::user()->role === 'admin' && $request->has('shelter_id')) {
            $caretaker->shelter_id = $request->shelter_id;
        }
        
        $caretaker->save();
        
        // Redirigir según el rol del usuario
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.caretakers.index')
                ->with('success', 'Cuidador actualizado exitosamente.');
        } else {
            return redirect()->route('caretaker.caretakers.index')
                ->with('success', 'Cuidador actualizado exitosamente.');
        }
    }

    /**
     * Toggle the active status of the specified caretaker.
     */
    public function toggleStatus(User $caretaker)
    {
        // Verificar que sea un cuidador
        if ($caretaker->role !== 'caretaker') {
            abort(404);
        }
        
        // Solo los administradores y los cuidadores del mismo albergue pueden cambiar el estado
        if (Auth::user()->role === 'admin' || 
            (Auth::user()->role === 'caretaker' && Auth::user()->shelter_id === $caretaker->shelter_id)) {
            
            // No permitir que un cuidador desactive su propia cuenta
            if (Auth::user()->role === 'caretaker' && Auth::user()->id === $caretaker->id) {
                return back()->withErrors([
                    'error' => 'No puedes cambiar el estado de tu propia cuenta.'
                ]);
            }
            
            $caretaker->is_active = !$caretaker->is_active;
            $caretaker->save();
            
            $status = $caretaker->is_active ? 'activado' : 'desactivado';
            
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.caretakers.index')
                    ->with('success', "Cuidador {$status} exitosamente.");
            } else {
                return redirect()->route('caretaker.caretakers.index')
                    ->with('success', "Cuidador {$status} exitosamente.");
            }
        }
        
        abort(403, 'No tienes permisos para cambiar el estado de este cuidador.');
    }

    /**
     * Remove the specified caretaker from storage.
     * En lugar de eliminar, cambiaremos el estado a inactivo.
     */
    public function destroy(User $caretaker)
    {
        // Verificar que sea un cuidador
        if ($caretaker->role !== 'caretaker') {
            abort(404);
        }
        
        // Solo los administradores pueden eliminar cuidadores
        if (Auth::user()->role === 'admin') {
            // En lugar de eliminar, desactivamos
            $caretaker->is_active = false;
            $caretaker->save();
            
            return redirect()->route('admin.caretakers.index')
                ->with('success', 'Cuidador desactivado exitosamente.');
        }
        
        abort(403, 'No tienes permisos para eliminar cuidadores.');
    }
}
