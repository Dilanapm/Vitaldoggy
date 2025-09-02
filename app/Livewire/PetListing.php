<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use App\Models\AdoptionApplication;
use Illuminate\Support\Facades\Auth;

class PetListing extends Component
{
    use WithPagination;

    public $search = '';
    public $filterByStatus = 'all';
    public $sortBy = 'latest';
    public $refreshInterval = 30; // Segundos para auto-refresh
    
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


    public function render()
    {
        return view('livewire.pet-listing', [
            'pets' => $this->getPets()
        ]);
    }
}
