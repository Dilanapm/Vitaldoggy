@extends('layouts.base')

@section('title', $shelter->name . ' - Refugio - VitalDoggy')
@section('description', 'Conoce ' . $shelter->name . ', refugio ubicado en ' . $shelter->city . '. Descubre las mascotas que están disponibles para adopción.')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900/75">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <a href="{{ route('shelters.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver a refugios
            </a>
        </div>
    </div>

    <!-- Información del refugio -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Imagen del refugio -->
        <div class="lg:col-span-1">
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                @if($shelter->hasImage())
                    <img src="{{ $shelter->image_url }}" 
                         alt="{{ $shelter->name }}"
                         class="w-full h-64 lg:h-80 object-cover">
                @else
                    <div class="w-full h-64 lg:h-80 bg-gradient-to-r from-[#751629]/20 to-[#f56e5c]/20 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-home text-6xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">{{ $shelter->name }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Información detallada -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Título y estado -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $shelter->name }}</h1>
                        <div class="flex items-center text-gray-600 dark:text-gray-400 mb-3">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <span class="text-lg">{{ $shelter->city }}</span>
                        </div>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-medium {{ $shelter->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-200' }}">
                        {{ $shelter->status_label }}
                    </span>
                </div>

                @if($shelter->description)
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4">{{ $shelter->description }}</p>
                @endif

                <!-- Estadísticas del refugio -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $shelter->capacity }}</div>
                        <div class="text-sm text-blue-800 dark:text-blue-300">Capacidad</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $shelter->pets->where('adoption_status', 'available')->count() }}</div>
                        <div class="text-sm text-green-800 dark:text-green-300">Disponibles</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $shelter->pets->count() }}</div>
                        <div class="text-sm text-yellow-800 dark:text-yellow-300">Total mascotas</div>
                    </div>
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Información de Contacto</h2>
                <div class="space-y-3">
                    @if($shelter->address)
                        <div class="flex items-start">
                            <i class="fas fa-home mr-3 mt-1 text-gray-500"></i>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Dirección:</span>
                                <p class="text-gray-700 dark:text-gray-300">{{ $shelter->address }}</p>
                            </div>
                        </div>
                    @endif

                    @if($shelter->phone)
                        <div class="flex items-center">
                            <i class="fas fa-phone mr-3 text-gray-500"></i>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Teléfono:</span>
                                <a href="tel:{{ $shelter->phone }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 ml-2">
                                    {{ $shelter->phone }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($shelter->email)
                        <div class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-gray-500"></i>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Email:</span>
                                <a href="mailto:{{ $shelter->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 ml-2">
                                    {{ $shelter->email }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mascotas del refugio -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Mascotas en {{ $shelter->name }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ $shelter->pets->count() }} mascotas en total
            </div>
        </div>

        @if($shelter->pets->count() > 0)
            <!-- Filtros -->
            <div class="mb-6 flex flex-wrap gap-2">
                <button onclick="filterPets('all')" 
                        class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-blue-500 text-white">
                    Todas ({{ $shelter->pets->count() }})
                </button>
                <button onclick="filterPets('available')" 
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Disponibles ({{ $shelter->pets->where('adoption_status', 'available')->count() }})
                </button>
                <button onclick="filterPets('pending')" 
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    En proceso ({{ $shelter->pets->where('adoption_status', 'pending')->count() }})
                </button>
                <button onclick="filterPets('adopted')" 
                        class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                    Adoptadas ({{ $shelter->pets->where('adoption_status', 'adopted')->count() }})
                </button>
            </div>

            <!-- Grid de mascotas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($shelter->pets as $pet)
                    <div class="pet-card bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden hover:shadow-xl transition duration-300" 
                         data-status="{{ $pet->adoption_status }}">
                        
                        <!-- Imagen de la mascota -->
                        <div class="relative">
                            @if($pet->photos && $pet->photos->count() > 0)
                                <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                                     alt="Foto de {{ $pet->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-paw text-4xl text-gray-400"></i>
                                </div>
                            @endif

                            <!-- Badge de estado -->
                            <div class="absolute top-2 right-2">
                                @if($pet->adoption_status === 'available')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                                        Disponible
                                    </span>
                                @elseif($pet->adoption_status === 'pending')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200">
                                        <span class="w-2 h-2 bg-yellow-600 rounded-full mr-1 animate-pulse"></span>
                                        En proceso
                                    </span>
                                @elseif($pet->adoption_status === 'adopted')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-1"></span>
                                        Adoptada
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Información de la mascota -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $pet->name }}</h3>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 mb-3">
                                <p><span class="font-medium">Especie:</span> {{ ucfirst($pet->species ?? 'No especificado') }}</p>
                                <p><span class="font-medium">Raza:</span> {{ $pet->breed ?? 'No especificado' }}</p>
                                <p><span class="font-medium">Edad:</span> {{ $pet->age ?? 'No especificado' }}</p>
                            </div>

                            <!-- Botón ver detalles -->
                            <a href="{{ route('pets.show', $pet) }}" 
                               class="block w-full text-center px-4 py-2 rounded-lg bg-blue-500 text-white font-medium hover:bg-blue-600 transition duration-200">
                                <i class="fas fa-eye mr-2"></i>Ver detalles
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No hay mascotas -->
            <div class="text-center py-12">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                    <i class="fas fa-paw text-6xl text-gray-400 mx-auto mb-4"></i>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay mascotas registradas</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Este refugio aún no tiene mascotas registradas en el sistema.
                    </p>
                </div>
            </div>
        @endif
    </div>

    <!-- Botones de acción -->
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('shelters.index') }}" 
           class="px-6 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Volver a refugios
        </a>
        
        <a href="{{ route('pets.index') }}" 
           class="px-6 py-3 rounded-lg bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg">
            <i class="fas fa-heart mr-2"></i>Ver todas las mascotas
        </a>
    </div>
</div>

<script>
function filterPets(status) {
    const cards = document.querySelectorAll('.pet-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Remover clase activa de todos los botones
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-blue-500', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300', 'dark:bg-gray-700', 'dark:text-gray-300', 'dark:hover:bg-gray-600');
    });
    
    // Agregar clase activa al botón clickeado
    event.target.classList.add('active', 'bg-blue-500', 'text-white');
    event.target.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300', 'dark:bg-gray-700', 'dark:text-gray-300', 'dark:hover:bg-gray-600');
    
    // Filtrar tarjetas
    cards.forEach(card => {
        const cardStatus = card.dataset.status;
        if (status === 'all' || cardStatus === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

@endsection