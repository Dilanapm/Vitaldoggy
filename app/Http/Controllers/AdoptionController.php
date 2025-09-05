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
     * Store a new adoption application
     */
    public function store(Request $request, Pet $pet)
    {
        // Validar los datos del formulario
        $request->validate([
            'reason' => 'required|string|max:1000',
            'has_experience' => 'required|boolean',
            'living_situation' => 'required|string|max:500',
            // Agregar más validaciones según tu formulario
        ]);

        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Debes iniciar sesión para solicitar una adopción.');
        }

        // Verificar que la mascota esté disponible
        if ($pet->adoption_status !== 'available') {
            return redirect()->route('pets.index')
                ->with('error', 'Esta mascota ya no está disponible para adopción.');
        }

        // Verificar si ya existe una solicitud pendiente
        $existingApplication = AdoptionApplication::where('user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->where('status', 'pending')
            ->first();

        if ($existingApplication) {
            return redirect()->route('pets.index')
                ->with('info', 'Ya tienes una solicitud pendiente para esta mascota.');
        }

        // Crear la solicitud de adopción
        $application = AdoptionApplication::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            'status' => 'pending',
            'reason' => $request->reason,
            'has_experience' => $request->has_experience,
            'living_situation' => $request->living_situation,
            'application_date' => now(),
            'applicant_info' => [
                'phone' => Auth::user()->phone,
                'address' => Auth::user()->address,
                'email' => Auth::user()->email,
            ],
        ]);

        // ¡ACTUALIZAR PROGRESO AUTOMÁTICAMENTE! (50% por enviar solicitud)
        // Verificar y actualizar el progreso del usuario usando el controlador dashboard
        app(UserDashboardController::class)->checkAndUnlockRoles(Auth::user());

        return redirect()->route('adoption.index')
            ->with('success', '¡Solicitud de adopción enviada exitosamente! Tu progreso se ha actualizado al 50%.');
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

    /**
     * Aprobar una solicitud de adopción (para admins/caretakers)
     */
    public function approve(AdoptionApplication $application)
    {
        $application->update([
            'status' => 'approved',
            'resolution_date' => now(),
            'resolved_by' => auth()->id(),
        ]);

        // Actualizar estado de la mascota
        $application->pet->update(['adoption_status' => 'adopted']);

        // ¡DESBLOQUEAR EL ROL DE ADOPTANTE AUTOMÁTICAMENTE!
        $user = $application->user;
        if (!$user->hasRole('adoptante')) {
            $user->becomeAdopter();
        }

        return redirect()->back()
            ->with('success', '¡Adopción aprobada! El usuario ha desbloqueado el rol de Adoptante.');
    }

    /**
     * Rechazar una solicitud de adopción (para admins/caretakers)
     */
    public function reject(AdoptionApplication $application, Request $request)
    {
        $application->update([
            'status' => 'rejected',
            'resolution_date' => now(),
            'resolved_by' => auth()->id(),
            'resolution_notes' => $request->input('reason'),
        ]);

        return redirect()->back()
            ->with('info', 'Solicitud de adopción rechazada.');
    }
}
