<?php

namespace App\Http\Controllers\Caretaker;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdoptionApplicationController extends Controller
{
    /**
     * Display a listing of adoption applications for the caretaker's shelter
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea un cuidador y tenga un refugio asignado
        if (!$user->shelter_id) {
            return redirect()->route('caretaker.dashboard')
                ->with('error', 'No tienes un refugio asignado.');
        }

        $query = AdoptionApplication::query()
            ->with(['user', 'pet', 'resolvedBy'])
            ->whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            });

        // Filtros
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('pet_id') && $request->pet_id !== '') {
            $query->where('pet_id', $request->pet_id);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('pet', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->latest('created_at')->paginate(15);

        // Obtener mascotas del refugio para el filtro
        $pets = Pet::where('shelter_id', $user->shelter_id)
                   ->where('adoption_status', 'available')
                   ->orderBy('name')
                   ->get();

        // Estadísticas rápidas
        $stats = [
            'total' => AdoptionApplication::whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            })->count(),
            'pending' => AdoptionApplication::whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            })->where('status', 'pending')->count(),
            'under_review' => AdoptionApplication::whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            })->where('status', 'under_review')->count(),
            'approved' => AdoptionApplication::whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            })->where('status', 'approved')->count(),
            'rejected' => AdoptionApplication::whereHas('pet', function ($q) use ($user) {
                $q->where('shelter_id', $user->shelter_id);
            })->where('status', 'rejected')->count(),
        ];

        return view('caretaker.adoption-applications.index', compact('applications', 'pets', 'stats'));
    }

    /**
     * Display the specified adoption application
     */
    public function show(AdoptionApplication $adoptionApplication)
    {
        $user = Auth::user();
        
        // Verificar que la solicitud pertenezca a una mascota del refugio del cuidador
        if ($adoptionApplication->pet->shelter_id !== $user->shelter_id) {
            abort(403, 'No tienes permiso para ver esta solicitud.');
        }

        $adoptionApplication->load(['user', 'pet', 'resolvedBy', 'documents']);

        return view('caretaker.adoption-applications.show', compact('adoptionApplication'));
    }

    /**
     * Approve an adoption application
     */
    public function approve(Request $request, AdoptionApplication $adoptionApplication)
    {
        $user = Auth::user();
        
        // Verificar que la solicitud pertenezca a una mascota del refugio del cuidador
        if ($adoptionApplication->pet->shelter_id !== $user->shelter_id) {
            abort(403, 'No tienes permiso para modificar esta solicitud.');
        }

        // Verificar que la solicitud esté en estado pendiente o en revisión
        if (!in_array($adoptionApplication->status, ['pending', 'under_review'])) {
            return redirect()->back()
                ->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        $request->validate([
            'resolution_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($adoptionApplication, $user, $request) {
            // Actualizar la solicitud
            $adoptionApplication->update([
                'status' => 'approved',
                'resolved_by' => $user->id,
                'resolution_date' => now(),
                'resolution_notes' => $request->resolution_notes
            ]);

            // Marcar la mascota como adoptada
            $adoptionApplication->pet->update([
                'adoption_status' => 'adopted',
                'adopted_at' => now()
            ]);

            // Rechazar todas las demás solicitudes pendientes para esta mascota
            AdoptionApplication::where('pet_id', $adoptionApplication->pet_id)
                ->where('status', 'pending')
                ->where('id', '!=', $adoptionApplication->id)
                ->update([
                    'status' => 'rejected',
                    'resolved_by' => $user->id,
                    'resolution_date' => now(),
                    'resolution_notes' => 'Rechazada automáticamente: otra solicitud fue aprobada.'
                ]);
        });

        return redirect()->route('caretaker.adoption-applications.index')
            ->with('success', 'Solicitud aprobada exitosamente. La mascota ha sido marcada como adoptada.');
    }

    /**
     * Reject an adoption application
     */
    public function reject(Request $request, AdoptionApplication $adoptionApplication)
    {
        $user = Auth::user();
        
        // Verificar que la solicitud pertenezca a una mascota del refugio del cuidador
        if ($adoptionApplication->pet->shelter_id !== $user->shelter_id) {
            abort(403, 'No tienes permiso para modificar esta solicitud.');
        }

        // Verificar que la solicitud esté en estado pendiente o en revisión
        if (!in_array($adoptionApplication->status, ['pending', 'under_review'])) {
            return redirect()->back()
                ->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        $request->validate([
            'resolution_notes' => 'required|string|max:1000'
        ]);

        $adoptionApplication->update([
            'status' => 'rejected',
            'resolved_by' => $user->id,
            'resolution_date' => now(),
            'resolution_notes' => $request->resolution_notes
        ]);

        return redirect()->route('caretaker.adoption-applications.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Mark an adoption application as under review
     */
    public function markAsUnderReview(Request $request, AdoptionApplication $adoptionApplication)
    {
        $user = Auth::user();
        
        // Verificar que la solicitud pertenezca a una mascota del refugio del cuidador
        if ($adoptionApplication->pet->shelter_id !== $user->shelter_id) {
            abort(403, 'No tienes permiso para modificar esta solicitud.');
        }

        // Verificar que la solicitud esté pendiente
        if ($adoptionApplication->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Solo se pueden marcar como "en revisión" las solicitudes pendientes.');
        }

        $request->validate([
            'resolution_notes' => 'nullable|string|max:1000'
        ]);

        $adoptionApplication->update([
            'status' => 'under_review',
            'resolved_by' => $user->id,
            'resolution_notes' => $request->resolution_notes
        ]);

        return redirect()->route('caretaker.adoption-applications.index')
            ->with('success', 'Solicitud marcada como en revisión.');
    }
}