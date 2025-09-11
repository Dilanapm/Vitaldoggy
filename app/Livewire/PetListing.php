<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PetListing extends Component
{
    use WithPagination;

    public $search = '';
    public $filterByStatus = 'all';
    public $sortBy = 'latest';
    public $refreshInterval = 30; // Segundos para auto-refresh
    public $showPetModal = false;
    public $selectedPet = null;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'filterByStatus' => ['except' => 'all'],
        'sortBy' => ['except' => 'latest']
    ];

    // Escuchar eventos para actualizaciones en tiempo real
    protected $listeners = [
        'adoptionStatusChanged' => 'refreshPets',
        'newAdoptionApplication' => 'refreshPets',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterByStatus()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function refreshPets()
    {
        // Método para refrescar la lista de mascotas
        $this->dispatch('$refresh');
    }

    public function mount()
    {
        // Configuración inicial si es necesaria
    }

    public function getUserApplicationStatus($petId)
    {
        if (!Auth::check()) {
            return null;
        }

        return AdoptionApplication::where('user_id', Auth::id())
            ->where('pet_id', $petId)
            ->whereIn('status', ['pending', 'under_review', 'approved'])
            ->first();
    }

    public function getPets()
    {
        $query = \App\Models\Pet::query()
            // Foto primaria (rápido) + conteo de postulaciones
            ->with(['primaryPhoto:id,pet_id,photo_path'])
            ->withCount('adoptionApplications');

        // Búsqueda (limpia y opcional)
        $query->when(
            filled(trim($this->search)),
            function ($q) {
                $s = '%' . trim($this->search) . '%';
                $q->where(function ($qq) use ($s) {
                    $qq->where('name', 'like', $s)
                    ->orWhere('breed', 'like', $s)
                    ->orWhere('description', 'like', $s);
                });
            }
        );

        // Filtro por estado (si no es 'all')
        $query->when(
            $this->filterByStatus !== 'all',
            fn($q) => $q->where('adoption_status', $this->filterByStatus)
        );

        // Orden
        $query
            ->when($this->sortBy === 'name', function ($q) {
                // Case-insensitive; usa COLLATE si tu collation no es CI
                $q->orderByRaw('LOWER(name) ASC');
            })
            ->when($this->sortBy === 'age', function ($q) {
                // NULLS LAST para age_months
                $q->orderByRaw('age_months IS NULL, age_months ASC');
            })
            ->when($this->sortBy === 'oldest', fn($q) => $q->orderBy('created_at', 'asc'))
            ->when(! in_array($this->sortBy, ['name','age','oldest'], true),
                fn($q) => $q->orderBy('created_at','desc'));

        // Si quieres que conserve los parámetros en los links de paginación:
        return $query->paginate(20)->withQueryString();
    }

    /**
     * Mostrar detalles de la mascota en modal
     */
    public function showPetDetails($petId)
    {
        $pet = Pet::with(['photos', 'shelter', 'adoptionApplications'])->findOrFail($petId);
        
        // Verificar autorización
        if (!Gate::allows('view', $pet)) {
            session()->flash('error', 'No tienes permisos para ver esta mascota.');
            return;
        }

        $this->selectedPet = $pet;
        $this->showPetModal = true;
    }

    /**
     * Cerrar modal de detalles
     */
    public function closePetModal()
    {
        $this->showPetModal = false;
        $this->selectedPet = null;
    }

    /**
     * Editar mascota (redirigir a formulario de edición)
     */
    public function editPet($petId)
    {
        $pet = Pet::findOrFail($petId);
        
        // Verificar autorización usando Policy
        if (!Gate::allows('update', $pet)) {
            session()->flash('error', 'No tienes permisos para editar esta mascota.');
            return;
        }

        // Redirigir a la ruta de edición correspondiente según el rol
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.pets.edit', $pet);
        } elseif (Auth::user()->role === 'caretaker') {
            return redirect()->route('caretaker.pets.edit', $pet);
        }
    }

    /**
     * Marcar mascota como adoptada
     */
    public function markAsAdopted($petId)
    {
        $pet = Pet::findOrFail($petId);
        
        // Verificar autorización usando Policy
        if (!Gate::allows('manageAdoption', $pet)) {
            session()->flash('error', 'No tienes permisos para marcar esta mascota como adoptada.');
            return;
        }

        try {
            $pet->update(['adoption_status' => 'adopted']);
            
            session()->flash('success', "¡{$pet->name} ha sido marcada como adoptada!");
            $this->dispatch('adoptionStatusChanged');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al marcar la mascota como adoptada.');
        }
    }

    /**
     * Cambiar estado de la mascota (activar/desactivar)
     */
    public function togglePetStatus($petId)
    {
        $pet = Pet::findOrFail($petId);
        
        // Verificar autorización usando Policy
        if (!Gate::allows('toggleStatus', $pet)) {
            session()->flash('error', 'No tienes permisos para cambiar el estado de esta mascota.');
            return;
        }

        try {
            $newStatus = match($pet->adoption_status) {
                'available' => 'inactive',
                'inactive' => 'available',
                'pending' => 'available', // Si está pending, permitir reactivar
                default => 'inactive'
            };
            
            $pet->update(['adoption_status' => $newStatus]);
            
            $action = $newStatus === 'inactive' ? 'desactivada' : 'activada';
            session()->flash('success', "¡{$pet->name} ha sido {$action}!");
            $this->dispatch('adoptionStatusChanged');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cambiar el estado de la mascota.');
        }
    }

    /**
     * Mostrar solicitudes de adopción
     */
    public function showApplications($petId)
    {
        $pet = Pet::findOrFail($petId);
        
        // Verificar autorización usando Policy
        if (!Gate::allows('viewApplications', $pet)) {
            session()->flash('error', 'No tienes permisos para ver las solicitudes de esta mascota.');
            return;
        }

        // Redirigir a la página de solicitudes correspondiente según el rol
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.pets.applications', $pet);
        } elseif (Auth::user()->role === 'caretaker') {
            return redirect()->route('caretaker.pets.applications', $pet);
        }
    }

    /**
     * Verificar si el usuario puede realizar acciones administrativas
     */
    public function canManagePets()
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'caretaker']);
    }

    /**
     * Verificar si el usuario puede adoptar mascotas
     */
    public function canAdoptPets()
    {
        return Auth::check() && Auth::user()->role === 'user';
    }


    public function render()
    {
        return view('livewire.pet-listing', [
            'pets' => $this->getPets()
        ]);
    }
}
