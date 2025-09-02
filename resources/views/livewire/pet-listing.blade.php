<div class="container mx-auto px-4 py-2 dark:bg-gray-900/75">
    <div class="mb-8">
        <div class="text-center mb-6">
            <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                    Mascotas en Adopción
                </span>
            </h1>
        </div>
        
        <!-- Filtros y búsqueda -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Búsqueda -->
            <div>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar por nombre, raza..."
                       class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
            </div>
            
            <!-- Filtro por estado -->
            <div>
                <select wire:model.live="filterByStatus" 
                        class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white">
                    <option value="all">Todos los estados</option>
                    <option value="available">Disponibles</option>
                    <option value="pending">En proceso</option>
                    <option value="adopted">Adoptados</option>
                </select>
            </div>
            
            <!-- Ordenar -->
            <div>
                
                <select wire:model.live="sortBy" 
                        class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white">
                    <option value="latest">Más recientes</option>
                    <option value="oldest">Más antiguos</option>
                    <option value="name">Por nombre</option>
                    <option value="age">Por edad</option>
                </select>
            </div>
        </div>
        <button wire:click="refreshPets" 
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-lg hover:from-[#751629]/90 hover:to-[#f56e5c]/90 transition duration-200 shadow-lg">
                <svg wire:loading.remove wire:target="refreshPets" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <svg wire:loading wire:target="refreshPets" class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Actualizar
            </button>
    </div>

    <!-- Indicador de carga -->
    <div wire:loading class="text-center py-4">
        <div class="inline-flex items-center px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg shadow-lg">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-[#f56e5c]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-300">Actualizando...</span>
        </div>
        
    </div>

    <!-- Grid de mascotas -->
    <div wire:loading.remove class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        
        @forelse($pets as $pet)
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden flex flex-col relative hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                <!-- Badge de estado -->
                <div class="absolute top-2 right-2 z-10">
                    @if($pet->adoption_status === 'available')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100/90 text-green-800 dark:bg-green-900/90 dark:text-green-200 backdrop-blur-sm border border-green-200/50 dark:border-green-800/50">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                            Disponible
                        </span>
                    @elseif($pet->adoption_status === 'pending')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100/90 text-yellow-800 dark:bg-yellow-900/90 dark:text-yellow-200 backdrop-blur-sm border border-yellow-200/50 dark:border-yellow-800/50">
                            <span class="w-2 h-2 bg-yellow-600 rounded-full mr-1 animate-pulse"></span>
                            En proceso
                        </span>
                    @elseif($pet->adoption_status === 'adopted')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100/90 text-blue-800 dark:bg-blue-900/90 dark:text-blue-200 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-1"></span>
                            Adoptado
                        </span>
                    @endif
                </div>

                <!-- Imagen de la mascota -->
                @if($pet->photos && $pet->photos->count())
                    <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                         alt="Foto de {{ $pet->name }}" 
                         class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif

                <div class="p-4 flex-1 flex flex-col">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $pet->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $pet->breed ?? 'Raza desconocida' }}</p>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Edad: {{ $pet->age ?? 'N/D' }}</p>
                    
                    <!-- Estado de solicitud del usuario -->
                    @auth
                        @php
                            $userApplication = $this->getUserApplicationStatus($pet->id);
                        @endphp
                        @if($userApplication)
                            <div class="mb-3 p-2 bg-blue-50/90 dark:bg-blue-900/20 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded text-sm">
                                <div class="flex items-center text-blue-700 dark:text-blue-300">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Tu solicitud: 
                                    @if($userApplication->status === 'pending')
                                        <span class="font-medium">Pendiente</span>
                                    @elseif($userApplication->status === 'under_review')
                                        <span class="font-medium">En revisión</span>
                                    @elseif($userApplication->status === 'approved')
                                        <span class="font-medium text-green-600">Aprobada</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endauth
                    
                    <div class="mt-auto">
                        @auth
                            @if($pet->adoption_status === 'available')
                                @php
                                    $userApplication = $this->getUserApplicationStatus($pet->id);
                                @endphp
                                @if($userApplication)
                                    <button disabled
                                            class="block w-full text-center px-4 py-2 rounded bg-gray-500/80 text-white font-medium cursor-not-allowed backdrop-blur-sm">
                                        Solicitud enviada
                                    </button>
                                @else
                                    <a href="{{ route('adoption.create', $pet) }}" 
                                       class="block w-full text-center px-4 py-2 rounded bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg">
                                        Solicitar adopción
                                    </a>
                                @endif
                            @elseif($pet->adoption_status === 'pending')
                                <button disabled
                                        class="block w-full text-center px-4 py-2 rounded bg-orange-500/80 text-white font-medium cursor-not-allowed backdrop-blur-sm">
                                    En proceso de adopción
                                </button>
                            @else
                                <button disabled
                                        class="block w-full text-center px-4 py-2 rounded bg-blue-400/80 text-white font-medium cursor-not-allowed backdrop-blur-sm">
                                    Ya adoptado
                                </button>
                            @endif
                        @else
                            @if($pet->adoption_status === 'available')
                                <a href="{{ route('login') }}" 
                                   class="block w-full text-center px-4 py-2 rounded bg-gray-500/80 text-white font-medium hover:bg-gray-600/80 transition duration-200 backdrop-blur-sm">
                                    Inicia sesión para adoptar
                                </a>
                            @else
                                <button disabled
                                        class="block w-full text-center px-4 py-2 rounded bg-gray-400/80 text-white font-medium cursor-not-allowed backdrop-blur-sm">
                                    No disponible
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No se encontraron mascotas</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        @if(!empty($search))
                            No hay mascotas que coincidan con "{{ $search }}"
                        @else
                            No hay mascotas disponibles en este momento.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($pets->hasPages())
        <div class="mt-8">
            {{ $pets->links() }}
        </div>
    @endif
</div>
