@extends('layouts.app')

@section('title', 'Detalles de ' . $pet->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.pets.index') }}" 
               class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pet->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Detalles de la mascota</p>
            </div>
        </div>
        
        <div class="flex space-x-3">
            <a href="{{ route('admin.pets.edit', $pet) }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-600 to-yellow-700 text-white rounded-lg hover:from-yellow-700 hover:to-yellow-800 transition duration-200 shadow-lg">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            
            <form action="{{ route('admin.pets.toggle-status', $pet) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r {{ $pet->adoption_status === 'available' ? 'from-red-600 to-red-700 hover:from-red-700 hover:to-red-800' : 'from-green-600 to-green-700 hover:from-green-700 hover:to-green-800' }} text-white rounded-lg transition duration-200 shadow-lg"
                        onclick="return confirm('¿Estás seguro de {{ $pet->adoption_status === 'available' ? 'desactivar' : 'activar' }} a {{ $pet->name }}?')">
                    <i class="fas {{ $pet->adoption_status === 'available' ? 'fa-ban' : 'fa-check' }} mr-2"></i>
                    {{ $pet->adoption_status === 'available' ? 'Desactivar' : 'Activar' }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Información básica -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Básica</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nombre</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Especie</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">
                            @switch($pet->species)
                                @case('dog') Perro @break
                                @case('cat') Gato @break
                                @case('other') Otro @break
                                @default {{ ucfirst($pet->species) }}
                            @endswitch
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Raza</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->breed ?? 'No especificada' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Edad</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->age ?? 'Desconocida' }} años</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Género</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">
                            {{ $pet->gender === 'male' ? 'Macho' : 'Hembra' }}
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tamaño</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">
                            @switch($pet->size)
                                @case('small') Pequeño @break
                                @case('medium') Mediano @break
                                @case('large') Grande @break
                                @default {{ ucfirst($pet->size) }}
                            @endswitch
                        </p>
                    </div>
                    
                    @if($pet->weight)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Peso</label>
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->weight }} kg</p>
                        </div>
                    @endif
                    
                    @if($pet->color)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Color</label>
                            <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->color }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Descripción -->
            @if($pet->description)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Descripción</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $pet->description }}</p>
                </div>
            @endif

            <!-- Información médica -->
            @if($pet->medical_info)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Médica</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $pet->medical_info }}</p>
                </div>
            @endif

            <!-- Notas de comportamiento -->
            @if($pet->behavior_notes)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Comportamiento</h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $pet->behavior_notes }}</p>
                </div>
            @endif

            <!-- Solicitudes de adopción -->
            @if($pet->adoptionApplications && $pet->adoptionApplications->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                        Solicitudes de Adopción ({{ $pet->adoptionApplications->count() }})
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($pet->adoptionApplications as $application)
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $application->user->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $application->user->email }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Solicitado: {{ $application->created_at->format('d/m/Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($application->status)
                                                @case('pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 @break
                                                @case('under_review') bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 @break
                                                @case('approved') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 @break
                                                @case('rejected') bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @break
                                            @endswitch
                                        ">
                                            @switch($application->status)
                                                @case('pending') Pendiente @break
                                                @case('under_review') En revisión @break
                                                @case('approved') Aprobada @break
                                                @case('rejected') Rechazada @break
                                            @endswitch
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Fotos -->
            @if($pet->photos && $pet->photos->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Fotos</h3>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($pet->photos as $photo)
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                 alt="Foto de {{ $pet->name }}" 
                                 class="w-full h-48 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Fotos</h3>
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-image text-4xl mb-2"></i>
                        <p>Sin fotos disponibles</p>
                    </div>
                </div>
            @endif

            <!-- Estado y ubicación -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Estado y Ubicación</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Estado de Adopción</label>
                        <div class="mt-1">
                            @switch($pet->adoption_status)
                                @case('available')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                        Disponible
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                        En proceso
                                    </span>
                                    @break
                                @case('adopted')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                        Adoptado
                                    </span>
                                    @break
                                @case('inactive')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300">
                                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                        Inactivo
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Refugio</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->shelter->name ?? 'Sin refugio asignado' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Cuidador</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->caretaker->name ?? 'Sin cuidador asignado' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de registro</label>
                        <p class="mt-1 text-lg font-medium text-gray-900 dark:text-white">{{ $pet->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Estado de salud -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Estado de Salud</h3>
                
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($pet->is_sterilized)
                                <i class="fas fa-check-circle text-green-500"></i>
                            @else
                                <i class="fas fa-times-circle text-red-500"></i>
                            @endif
                        </div>
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $pet->is_sterilized ? 'Esterilizado/a' : 'No esterilizado/a' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($pet->is_vaccinated)
                                <i class="fas fa-check-circle text-green-500"></i>
                            @else
                                <i class="fas fa-times-circle text-red-500"></i>
                            @endif
                        </div>
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $pet->is_vaccinated ? 'Vacunado/a' : 'No vacunado/a' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($pet->is_dewormed)
                                <i class="fas fa-check-circle text-green-500"></i>
                            @else
                                <i class="fas fa-times-circle text-red-500"></i>
                            @endif
                        </div>
                        <div class="ml-3">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $pet->is_dewormed ? 'Desparasitado/a' : 'No desparasitado/a' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection