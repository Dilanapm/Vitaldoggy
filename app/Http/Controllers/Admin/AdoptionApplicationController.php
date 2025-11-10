<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdoptionApplicationController extends Controller
{
    /**
     * Display a listing of all adoption applications (admin view)
     */
    public function index(Request $request)
    {
        $query = AdoptionApplication::query()
            ->with(['user', 'pet.shelter', 'resolvedBy']);

        // Filtros
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('shelter_id') && $request->shelter_id !== '') {
            $query->whereHas('pet', function ($q) use ($request) {
                $q->where('shelter_id', $request->shelter_id);
            });
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
                })
                ->orWhereHas('pet.shelter', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->latest('created_at')->paginate(20);

        // Obtener refugios y mascotas para los filtros
        $shelters = Shelter::where('is_active', true)->orderBy('name')->get();
        $pets = Pet::where('adoption_status', 'available')->orderBy('name')->get();

        // Estadísticas globales
        $stats = [
            'total' => AdoptionApplication::count(),
            'pending' => AdoptionApplication::where('status', 'pending')->count(),
            'under_review' => AdoptionApplication::where('status', 'under_review')->count(),
            'approved' => AdoptionApplication::where('status', 'approved')->count(),
            'rejected' => AdoptionApplication::where('status', 'rejected')->count(),
        ];

        // Estadísticas por refugio
        $shelterStats = Shelter::withCount([
            'pets as total_pets',
            'pets as available_pets' => function ($query) {
                $query->where('adoption_status', 'available');
            },
            'pets as adopted_pets' => function ($query) {
                $query->where('adoption_status', 'adopted');
            }
        ])->get()->map(function ($shelter) {
            $shelter->pending_applications = AdoptionApplication::whereHas('pet', function ($q) use ($shelter) {
                $q->where('shelter_id', $shelter->id);
            })->where('status', 'pending')->count();
            
            return $shelter;
        });

        return view('admin.adoption-applications.index', compact('applications', 'shelters', 'pets', 'stats', 'shelterStats'));
    }

    /**
     * Display the specified adoption application
     */
    public function show(AdoptionApplication $adoptionApplication)
    {
        $adoptionApplication->load(['user', 'pet.shelter', 'resolvedBy', 'documents']);

        // Obtener cuidadores del refugio de la mascota para asignación
        $caretakers = User::where('role', 'caretaker')
            ->where('shelter_id', $adoptionApplication->pet->shelter_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.adoption-applications.show', compact('adoptionApplication', 'caretakers'));
    }

    /**
     * Approve an adoption application (admin action)
     */
    public function approve(Request $request, AdoptionApplication $adoptionApplication)
    {
        // Verificar que la solicitud esté en estado pendiente o en revisión
        if (!in_array($adoptionApplication->status, ['pending', 'under_review'])) {
            return redirect()->back()
                ->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        $request->validate([
            'resolution_notes' => 'nullable|string|max:1000'
        ]);

        DB::transaction(function () use ($adoptionApplication, $request) {
            // Actualizar la solicitud
            $adoptionApplication->update([
                'status' => 'approved',
                'resolved_by' => Auth::id(),
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
                    'resolved_by' => Auth::id(),
                    'resolution_date' => now(),
                    'resolution_notes' => 'Rechazada automáticamente: otra solicitud fue aprobada por el administrador.'
                ]);
        });

        return redirect()->route('admin.adoption-applications.index')
            ->with('success', 'Solicitud aprobada exitosamente. La mascota ha sido marcada como adoptada.');
    }

    /**
     * Reject an adoption application (admin action)
     */
    public function reject(Request $request, AdoptionApplication $adoptionApplication)
    {
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
            'resolved_by' => Auth::id(),
            'resolution_date' => now(),
            'resolution_notes' => $request->resolution_notes
        ]);

        return redirect()->route('admin.adoption-applications.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Mark an adoption application as under review (admin action)
     */
    public function markAsUnderReview(Request $request, AdoptionApplication $adoptionApplication)
    {
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
            'resolved_by' => Auth::id(),
            'resolution_notes' => $request->resolution_notes
        ]);

        return redirect()->route('admin.adoption-applications.index')
            ->with('success', 'Solicitud marcada como en revisión.');
    }

    /**
     * Assign a caretaker to handle an adoption application
     */
    public function assignCaretaker(Request $request, AdoptionApplication $adoptionApplication)
    {
        $request->validate([
            'caretaker_id' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:500'
        ]);

        // Verificar que el cuidador seleccionado pertenezca al refugio correcto
        $caretaker = User::where('id', $request->caretaker_id)
            ->where('role', 'caretaker')
            ->where('shelter_id', $adoptionApplication->pet->shelter_id)
            ->where('is_active', true)
            ->first();

        if (!$caretaker) {
            return redirect()->back()
                ->with('error', 'El cuidador seleccionado no es válido para este refugio.');
        }

        // Actualizar notas si se proporcionaron
        if ($request->notes) {
            $currentNotes = $adoptionApplication->resolution_notes ?? '';
            $newNote = "\n\n[ADMIN - " . now()->format('d/m/Y H:i') . "] Asignado a: " . $caretaker->name . "\nNotas: " . $request->notes;
            
            $adoptionApplication->update([
                'resolution_notes' => $currentNotes . $newNote
            ]);
        }

        return redirect()->route('admin.adoption-applications.show', $adoptionApplication)
            ->with('success', "Solicitud asignada exitosamente al cuidador {$caretaker->name}.");
    }
}