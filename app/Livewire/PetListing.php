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
        $this->render();
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
        $query = Pet::with(['photos', 'adoptionApplications']);

        // Filtrar por búsqueda
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('breed', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Filtrar por estado
        if ($this->filterByStatus !== 'all') {
            $query->where('adoption_status', $this->filterByStatus);
        }

        // Ordenar
        switch ($this->sortBy) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'age':
                $query->orderBy('age', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.pet-listing', [
            'pets' => $this->getPets()
        ]);
    }
}
