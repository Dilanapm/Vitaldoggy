<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pet;
use App\Models\AdoptionApplication;
use App\Models\AdoptionDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdoptionForm extends Component
{
    use WithFileUploads;

    // Datos de la mascota
    public Pet $pet;

    // Datos del formulario
    public $reason = '';
    public $has_experience = false;
    public $living_situation = '';
    public $applicant_info = [
        'phone' => '',
        'address' => '',
        'occupation' => '',
        'family_members' => '',
        'other_pets' => '',
        'references' => '',
    ];

    // Archivos
    public $identification;
    public $proof_of_residence;
    public $other_documents = [];

    // Estados del formulario
    public $step = 1;
    public $maxSteps = 3;
    public $isSubmitting = false;
    public $submitted = false;

    protected $rules = [
        'reason' => 'required|min:50|max:1000',
        'living_situation' => 'required|min:30|max:500',
        'applicant_info.phone' => 'required|string|max:20',
        'applicant_info.address' => 'required|string|max:255',
        'applicant_info.occupation' => 'required|string|max:100',
        'applicant_info.family_members' => 'required|string|max:500',
        'identification' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'proof_of_residence' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ];

    protected $messages = [
        'reason.required' => 'Debes explicar por qué quieres adoptar esta mascota.',
        'reason.min' => 'La razón debe tener al menos 50 caracteres.',
        'living_situation.required' => 'Describe tu situación de vivienda.',
        'living_situation.min' => 'Describe más detalles sobre tu situación de vivienda.',
        'applicant_info.phone.required' => 'El teléfono es obligatorio.',
        'applicant_info.address.required' => 'La dirección es obligatoria.',
        'identification.required' => 'Debes subir una copia de tu identificación.',
        'identification.mimes' => 'La identificación debe ser un archivo JPG, PNG o PDF.',
        'proof_of_residence.required' => 'Debes subir un comprobante de domicilio.',
        'proof_of_residence.mimes' => 'El comprobante debe ser un archivo JPG, PNG o PDF.',
    ];

    public function mount(Pet $pet)
    {
        $this->pet = $pet;
        
        // Si el usuario está autenticado, pre-llenar algunos campos
        if (Auth::check()) {
            $user = Auth::user();
            $this->applicant_info['phone'] = $user->phone ?? '';
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->step < $this->maxSteps) {
            $this->step++;
        }
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    private function validateCurrentStep()
    {
        if ($this->step == 1) {
            $this->validate([
                'reason' => 'required|min:50|max:1000',
                'living_situation' => 'required|min:30|max:500',
            ]);
        } elseif ($this->step == 2) {
            $this->validate([
                'applicant_info.phone' => 'required|string|max:20',
                'applicant_info.address' => 'required|string|max:255',
                'applicant_info.occupation' => 'required|string|max:100',
                'applicant_info.family_members' => 'required|string|max:500',
            ]);
        }
    }

    public function submit()
    {
        // Validar todo el formulario
        $this->validate();

        $this->isSubmitting = true;

        try {
            // Crear la solicitud de adopción
            $application = AdoptionApplication::create([
                'user_id' => Auth::id(),
                'pet_id' => $this->pet->id,
                'reason' => $this->reason,
                'has_experience' => $this->has_experience,
                'living_situation' => $this->living_situation,
                'applicant_info' => $this->applicant_info,
                'priority_score' => $this->calculatePriorityScore(),
            ]);

            // Subir y guardar documentos
            $this->uploadDocuments($application);

            $this->submitted = true;
            
            // Emitir evento para actualizar el listado de mascotas
            $this->dispatch('newAdoptionApplication', petId: $this->pet->id);
            
            session()->flash('success', '¡Tu solicitud de adopción ha sido enviada exitosamente! Te contactaremos pronto.');

        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un error al enviar tu solicitud. Por favor, inténtalo de nuevo.');
        } finally {
            $this->isSubmitting = false;
        }
    }

    private function uploadDocuments($application)
    {
        // Crear directorio si no existe
        Storage::disk('public')->makeDirectory('adoption_documents');

        // Subir identificación
        if ($this->identification) {
            $idPath = $this->identification->store('adoption_documents', 'public');
            AdoptionDocument::create([
                'adoption_application_id' => $application->id,
                'document_type' => AdoptionDocument::TYPE_ID,
                'file_path' => basename($idPath),
                'original_filename' => $this->identification->getClientOriginalName(),
                'file_size' => $this->identification->getSize(),
                'mime_type' => $this->identification->getMimeType(),
            ]);
        }

        // Subir comprobante de domicilio
        if ($this->proof_of_residence) {
            $proofPath = $this->proof_of_residence->store('adoption_documents', 'public');
            AdoptionDocument::create([
                'adoption_application_id' => $application->id,
                'document_type' => AdoptionDocument::TYPE_PROOF_OF_RESIDENCE,
                'file_path' => basename($proofPath),
                'original_filename' => $this->proof_of_residence->getClientOriginalName(),
                'file_size' => $this->proof_of_residence->getSize(),
                'mime_type' => $this->proof_of_residence->getMimeType(),
            ]);
        }

        // Subir otros documentos
        foreach ($this->other_documents as $doc) {
            if ($doc) {
                $docPath = $doc->store('adoption_documents', 'public');
                AdoptionDocument::create([
                    'adoption_application_id' => $application->id,
                    'document_type' => AdoptionDocument::TYPE_OTHER,
                    'file_path' => basename($docPath),
                    'original_filename' => $doc->getClientOriginalName(),
                    'file_size' => $doc->getSize(),
                    'mime_type' => $doc->getMimeType(),
                ]);
            }
        }
    }

    private function calculatePriorityScore()
    {
        $score = 0;
        
        // Puntos por experiencia
        if ($this->has_experience) {
            $score += 20;
        }

        // Puntos por razón detallada
        if (strlen($this->reason) > 100) {
            $score += 15;
        }

        // Puntos por información completa
        if (!empty($this->applicant_info['references'])) {
            $score += 10;
        }

        return $score;
    }

    public function render()
    {
        return view('livewire.adoption-form');
    }
}
