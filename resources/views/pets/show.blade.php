@extends('layouts.base')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900/75">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('pets.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a la lista
            </a>
        </div>
        
        <div class="flex items-center space-x-4 mb-6">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $pet->name }}</h1>
            
            <!-- Badge de estado -->
            @if($pet->adoption_status === 'available')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                    Disponible para adopción
                </span>
            @elseif($pet->adoption_status === 'pending')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200">
                    <span class="w-2 h-2 bg-yellow-600 rounded-full mr-2 animate-pulse"></span>
                    En proceso de adopción
                </span>
            @elseif($pet->adoption_status === 'adopted')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                    <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                    Ya adoptado
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Columna izquierda: Fotos -->
        <div class="space-y-6">
            @if($pet->photos && $pet->photos->count() > 0)
                <!-- Foto principal -->
                <div class="relative">
                    <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                         alt="Foto principal de {{ $pet->name }}"
                         class="w-full h-96 object-cover rounded-lg shadow-lg">
                </div>
                
                <!-- Galería de fotos adicionales -->
                @if($pet->photos->count() > 1)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Más fotos</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($pet->photos->skip(1) as $photo)
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                     alt="Foto de {{ $pet->name }}"
                                     class="w-full h-24 object-cover rounded-lg shadow-md hover:shadow-lg transition duration-200 cursor-pointer">
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div class="w-full h-96 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                    <div class="text-center">
                        <i class="fas fa-camera text-6xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">Sin fotos disponibles</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Columna derecha: Información -->
        <div class="space-y-6">
            <!-- Información básica -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Información Básica</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Especie:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($pet->species ?? 'No especificado') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Raza:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $pet->breed ?? 'No especificado' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Edad:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $pet->age ?? 'No especificado' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Tamaño:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($pet->size ?? 'No especificado') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Género:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $pet->gender === 'male' ? 'Macho' : ($pet->gender === 'female' ? 'Hembra' : 'No especificado') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Color:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $pet->color ?? 'No especificado' }}</span>
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            @if($pet->description)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Descripción</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $pet->description }}</p>
                </div>
            @endif

            <!-- Estado de salud -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Estado de Salud</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Estado general:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($pet->health_status ?? 'No especificado') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Esterilizado:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            @if($pet->is_sterilized === 1)
                                <span class="text-green-600 dark:text-green-400">✓ Sí</span>
                            @elseif($pet->is_sterilized === 0)
                                <span class="text-red-600 dark:text-red-400">✗ No</span>
                            @else
                                No especificado
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Vacunado:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            @if($pet->is_vaccinated === 1)
                                <span class="text-green-600 dark:text-green-400">✓ Sí</span>
                            @elseif($pet->is_vaccinated === 0)
                                <span class="text-red-600 dark:text-red-400">✗ No</span>
                            @else
                                No especificado
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Refugio -->
            @if($pet->shelter)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Refugio</h2>
                    <div class="space-y-2">
                        <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $pet->shelter->name }}</p>
                        @if($pet->shelter->city)
                            <p class="text-gray-600 dark:text-gray-400">{{ $pet->shelter->city }}</p>
                        @endif
                        @if($pet->shelter->address)
                            <p class="text-gray-600 dark:text-gray-400">{{ $pet->shelter->address }}</p>
                        @endif
                        @if($pet->shelter->phone)
                            <p class="text-gray-600 dark:text-gray-400">
                                <i class="fas fa-phone mr-2"></i>{{ $pet->shelter->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Botones de acción -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                @auth
                    @if($pet->adoption_status === 'available')
                        <a href="{{ route('adoption.create', $pet) }}" 
                           class="block w-full text-center px-6 py-3 rounded-lg bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg mb-3">
                            <i class="fas fa-heart mr-2"></i>Solicitar adopción
                        </a>
                    @elseif($pet->adoption_status === 'pending')
                        <button disabled
                                class="block w-full text-center px-6 py-3 rounded-lg bg-orange-500/80 text-white font-medium cursor-not-allowed mb-3">
                            <i class="fas fa-hourglass-half mr-2"></i>En proceso de adopción
                        </button>
                    @elseif($pet->adoption_status === 'adopted')
                        <button disabled
                                class="block w-full text-center px-6 py-3 rounded-lg bg-blue-400/80 text-white font-medium cursor-not-allowed mb-3">
                            <i class="fas fa-check-circle mr-2"></i>Ya adoptado
                        </button>
                    @endif
                @else
                    @if($pet->adoption_status === 'available')
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center px-6 py-3 rounded-lg bg-gray-500/80 text-white font-medium hover:bg-gray-600/80 transition duration-200 mb-3">
                            <i class="fas fa-sign-in-alt mr-2"></i>Inicia sesión para adoptar
                        </a>
                    @endif
                @endauth
                
                <a href="{{ route('pets.index') }}" 
                   class="block w-full text-center px-6 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Volver a la lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection