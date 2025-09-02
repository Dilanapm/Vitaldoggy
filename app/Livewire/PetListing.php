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
        $query = Pet::query()
        // Carga solo la foto primaria (sin traer todas)
        ->with(['primaryPhoto:id,pet_id,photo_path'])
        // Si quieres saber si tiene postulaciones, esto te da el conteo:
        ->withCount('adoptionApplications');

         // Búsqueda
        if (!empty($this->search)) {
            $s = '%'.$this->search.'%'; // esta linea hace que la búsqueda sea más flexible
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', $s)
                ->orWhere('breed', 'like', $s)
                ->orWhere('description', 'like', $s);
            });
        }

        // Filtrar por estado
        if ($this->filterByStatus !== 'all') {
            $query->where('adoption_status', $this->filterByStatus);
        }


        // Ordenar
        $query->when($this->sortBy === 'name',   fn($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortBy === 'age',    fn($q) => $q->orderBy('age_months', 'asc')) // mejor que 'age' texto
            ->when($this->sortBy === 'oldest', fn($q) => $q->orderBy('created_at', 'asc'))
            ->when(!in_array($this->sortBy, ['name','age','oldest']),
                    fn($q) => $q->orderBy('created_at', 'desc'));

        return $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.pet-listing', [
            'pets' => $this->getPets()
        ]);
    }
}
