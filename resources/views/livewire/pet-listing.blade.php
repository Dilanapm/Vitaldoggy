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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Búsqueda -->
            <div class="lg:col-span-1">
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="Buscar por nombre, raza, refugio..."
                       class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400">
            </div>
            
            <!-- Filtro por estado (solo admin y cuidadores) -->
            @auth
                @if(in_array(auth()->user()->role, ['admin', 'caretaker']))
                    <div>
                        <select wire:model.live="filterByStatus" 
                                class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white">
                            <option value="all">Todos los estados</option>
                            <option value="available">Disponibles</option>
                            <option value="pending">En proceso</option>
                            <option value="adopted">Adoptados</option>
                            <option value="inactive">Inactivos</option>
                        </select>
                    </div>
                @endif
                
                <!-- Filtro por refugio (solo admin) -->
                @if(auth()->user()->role === 'admin')
                    <div>
                        <select wire:model.live="filterByShelter" 
                                class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white">
                            <option value="all">Todos los refugios</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter->id }}">{{ $shelter->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endauth
            
            <!-- Ordenar -->
            <div>
                <select wire:model.live="sortBy" 
                        class="w-full px-4 py-2 border border-gray-300/50 dark:border-gray-600/50 rounded-lg focus:ring-primary focus:border-primary bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-900 dark:text-white">
                    <option value="latest">Más recientes</option>
                    <option value="oldest">Más antiguos</option>
                    <option value="name">Por nombre</option>
                    <option value="age">Por edad</option>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <option value="shelter">Por refugio</option>
                        @endif
                    @endauth
                </select>
            </div>
        </div>
        
        <!-- Información del contexto según rol -->
        @auth
            <div class="mb-4 p-3 bg-blue-50/80 dark:bg-blue-900/20 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded-lg">
                <div class="flex items-center text-blue-700 dark:text-blue-300 text-sm">
                    <i class="fas fa-info-circle mr-2"></i>
                    @if(auth()->user()->role === 'admin')
                        <span>Como <strong>administrador</strong>, puedes ver y gestionar todas las mascotas de todos los refugios.</span>
                    @elseif(auth()->user()->role === 'caretaker')
                        @php
                            $shelterName = auth()->user()->shelter ? auth()->user()->shelter->name : 'Sin refugio asignado';
                        @endphp
                        <span>Como <strong>cuidador</strong> del <strong>{{ $shelterName }}</strong>, puedes ver y gestionar las mascotas de tu refugio.</span>
                    @else
                        <span>Estás viendo todas las <strong>mascotas disponibles para adopción</strong> de todos los refugios.</span>
                    @endif
                </div>
            </div>
        @else
            <div class="mb-4 p-3 bg-green-50/80 dark:bg-green-900/20 backdrop-blur-sm border border-green-200/50 dark:border-green-800/50 rounded-lg">
                <div class="flex items-center text-green-700 dark:text-green-300 text-sm">
                    <i class="fas fa-heart mr-2"></i>
                    <span>Estás viendo todas las <strong>mascotas disponibles para adopción</strong>. <a href="{{ route('login') }}" class="underline hover:no-underline">Inicia sesión</a> para solicitar adopciones.</span>
                </div>
            </div>
        @endauth
        
        <!-- Botón actualizar -->
        <div class="mb-4">
            <button wire:click="refreshPets" 
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-lg hover:from-[#751629]/90 hover:to-[#f56e5c]/90 transition duration-200 shadow-lg">
                <i wire:loading.remove wire:target="refreshPets" class="fas fa-sync mr-2"></i>
                <i wire:loading wire:target="refreshPets" class="fas fa-sync fa-spin mr-2"></i>
                Actualizar
            </button>
        </div>
    </div>

    <!-- Indicador de carga -->
    <div wire:loading class="text-center py-4">
        <div class="inline-flex items-center px-4 py-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 rounded-lg shadow-lg">
            <i class="fas fa-spinner fa-spin mr-3 text-[#f56e5c]"></i>
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
                        <i class="fas fa-image text-4xl"></i>
                    </div>
                @endif

                <div class="p-4 flex-1 flex flex-col">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ $pet->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-1">{{ $pet->breed ?? 'Raza desconocida' }}</p>
                    <p class="text-gray-500 dark:text-gray-400 mb-2">Edad: {{ $pet->age ?? 'N/D' }}</p>
                    
                    <!-- Información del refugio -->
                    @if($pet->shelter)
                        <div class="mb-3 flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <i class="fas fa-home mr-1"></i>
                            <span>{{ $pet->shelter->name }}</span>
                        </div>
                    @endif
                    
                    <!-- Estado de solicitud del usuario -->
                    @auth
                        @php
                            $userApplication = $this->getUserApplicationStatus($pet->id);
                        @endphp
                        @if($userApplication)
                            <div class="mb-3 p-2 bg-blue-50/90 dark:bg-blue-900/20 backdrop-blur-sm border border-blue-200/50 dark:border-blue-800/50 rounded text-sm">
                                <div class="flex items-center text-blue-700 dark:text-blue-300">
                                    <i class="fas fa-info-circle mr-2"></i>
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
                            @can('manageAdoption', $pet)
                                <!-- Panel de administración para admin y cuidadores autorizados -->
                                <div class="space-y-2">
                                    <!-- Botones de gestión administrativos -->
                                    <div class="flex space-x-1">
                                        @can('update', $pet)
                                            <!-- Editar mascota -->
                                            <button wire:click="editPet({{ $pet->id }})" 
                                                    class="flex-1 text-center px-2 py-1 rounded text-xs font-medium bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-900/50 dark:text-yellow-300 dark:hover:bg-yellow-800/50 transition duration-200"
                                                    title="Editar mascota">
                                                <i class="fas fa-edit mr-1"></i>Editar
                                            </button>
                                        @endcan
                                        
                                        @if($pet->adoption_status !== 'adopted')
                                            <!-- Marcar como adoptado -->
                                            <button wire:click="markAsAdopted({{ $pet->id }})" 
                                                    wire:confirm="¿Estás seguro de marcar a {{ $pet->name }} como adoptado?"
                                                    class="flex-1 text-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/50 dark:text-green-300 dark:hover:bg-green-800/50 transition duration-200"
                                                    title="Marcar como adoptado">
                                                <i class="fas fa-check-circle mr-1"></i>Adoptado
                                            </button>
                                        @endif
                                        
                                        @can('toggleStatus', $pet)
                                            @if($pet->adoption_status !== 'inactive')
                                                <!-- Desactivar mascota -->
                                                <button wire:click="togglePetStatus({{ $pet->id }})" 
                                                        wire:confirm="¿Estás seguro de {{ $pet->adoption_status === 'available' ? 'desactivar' : 'activar' }} a {{ $pet->name }}?"
                                                        class="flex-1 text-center px-2 py-1 rounded text-xs font-medium {{ $pet->adoption_status === 'available' ? 'bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/50 dark:text-red-300 dark:hover:bg-red-800/50' : 'bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/50 dark:text-green-300 dark:hover:bg-green-800/50' }} transition duration-200"
                                                        title="{{ $pet->adoption_status === 'available' ? 'Desactivar mascota' : 'Activar mascota' }}">
                                                    <i class="fas {{ $pet->adoption_status === 'available' ? 'fa-ban' : 'fa-check' }} mr-1"></i>
                                                    {{ $pet->adoption_status === 'available' ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            @else
                                                <!-- Reactivar mascota -->
                                                <button wire:click="togglePetStatus({{ $pet->id }})" 
                                                        wire:confirm="¿Estás seguro de reactivar a {{ $pet->name }}?"
                                                        class="flex-1 text-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/50 dark:text-green-300 dark:hover:bg-green-800/50 transition duration-200"
                                                        title="Reactivar mascota">
                                                    <i class="fas fa-undo mr-1"></i>Reactivar
                                                </button>
                                            @endif
                                        @endcan
                                    </div>
                                    
                                    <!-- Solicitudes de adopción -->
                                    @can('viewApplications', $pet)
                                        @if($pet->adoptionApplications && $pet->adoptionApplications->count() > 0)
                                            <button wire:click="showApplications({{ $pet->id }})" 
                                                    class="w-full text-center px-2 py-1 rounded text-xs font-medium bg-purple-100 text-purple-700 hover:bg-purple-200 dark:bg-purple-900/50 dark:text-purple-300 dark:hover:bg-purple-800/50 transition duration-200 relative"
                                                    title="Ver solicitudes ({{ $pet->adoptionApplications->count() }})">
                                                <i class="fas fa-clipboard-list mr-1"></i>
                                                Ver solicitudes ({{ $pet->adoptionApplications->count() }})
                                            </button>
                                        @endif
                                    @endcan
                                </div>
                            @else
                                <!-- Panel normal para adoptantes -->
                                @can('applyForAdoption', $pet)
                                    @if($pet->adoption_status === 'available')
                                        @php
                                            $userApplication = $this->getUserApplicationStatus($pet->id);
                                        @endphp
                                        @if($userApplication)
                                            <button disabled
                                                    class="block w-full text-center px-4 py-2 rounded bg-gray-500/80 text-white font-medium cursor-not-allowed backdrop-blur-sm mb-2">
                                                <i class="fas fa-clock mr-2"></i>Solicitud enviada
                                            </button>
                                        @else
                                            <a href="{{ route('adoption.create', $pet) }}" 
                                               class="block w-full text-center px-4 py-2 rounded bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg mb-2">
                                                <i class="fas fa-heart mr-2"></i>Solicitar adopción
                                            </a>
                                        @endif
                                    @endif
                                @else
                                    <!-- Estado para usuarios sin permisos de adopción -->
                                    @if($pet->adoption_status === 'pending')
                                        <button disabled
                                                class="block w-full text-center px-4 py-2 rounded bg-orange-500/80 text-white font-medium cursor-not-allowed backdrop-blur-sm mb-2">
                                            <i class="fas fa-hourglass-half mr-2"></i>En proceso de adopción
                                        </button>
                                    @elseif($pet->adoption_status === 'adopted')
                                        <button disabled
                                                class="block w-full text-center px-4 py-2 rounded bg-blue-400/80 text-white font-medium cursor-not-allowed backdrop-blur-sm mb-2">
                                            <i class="fas fa-check-circle mr-2"></i>Ya adoptado
                                        </button>
                                    @elseif($pet->adoption_status === 'inactive')
                                        <button disabled
                                                class="block w-full text-center px-4 py-2 rounded bg-gray-400/80 text-white font-medium cursor-not-allowed backdrop-blur-sm mb-2">
                                            <i class="fas fa-ban mr-2"></i>No disponible
                                        </button>
                                    @endif
                                @endcan
                            @endcan
                        @else
                            <!-- Panel para usuarios no autenticados -->
                            @if($pet->adoption_status === 'available')
                                <a href="{{ route('login') }}" 
                                   class="block w-full text-center px-4 py-2 rounded bg-gray-500/80 text-white font-medium hover:bg-gray-600/80 transition duration-200 backdrop-blur-sm mb-2">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Inicia sesión para adoptar
                                </a>
                            @else
                                <button disabled
                                        class="block w-full text-center px-4 py-2 rounded bg-gray-400/80 text-white font-medium cursor-not-allowed backdrop-blur-sm mb-2">
                                    <i class="fas fa-ban mr-2"></i>No disponible
                                </button>
                            @endif
                        @endauth
                        
                        <!-- BOTÓN ÚNICO "VER DETALLES" - SIEMPRE PRESENTE -->
                        <a href="{{ route('pets.show', $pet) }}" 
                           class="block w-full text-center px-4 py-2 rounded bg-blue-500/80 text-white font-medium hover:bg-blue-600/80 transition duration-200 backdrop-blur-sm"
                           title="Ver información completa de {{ $pet->name }}"
                           data-pet-link="true">
                            <i class="fas fa-eye mr-2"></i>Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-8">
                    <i class="fas fa-search text-6xl text-gray-400 mx-auto mb-4"></i>
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
