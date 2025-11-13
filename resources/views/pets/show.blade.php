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
        <!-- Columna izquierda: Carrusel de fotos -->
        <div class="space-y-6">
            @if($pet->photos && $pet->photos->count() > 0)
                <!-- Carrusel principal -->
                <div class="relative bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                    <!-- Contenedor del carrusel -->
                    <div class="relative h-96 overflow-hidden">
                        @foreach($pet->photos as $index => $photo)
                            <div class="carousel-item absolute inset-0 transition-transform duration-300 ease-in-out {{ $index === 0 ? '' : 'translate-x-full' }}" 
                                 data-slide="{{ $index }}">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                     alt="Foto {{ $index + 1 }} de {{ $pet->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                        @endforeach
                        
                        <!-- Overlay con información -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <div class="flex justify-between items-center text-white">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $pet->name }}</h3>
                                    <p class="text-sm opacity-90" id="photoCaption">Foto 1 de {{ $pet->photos->count() }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button onclick="toggleFullscreen()" 
                                            class="p-2 bg-black/50 hover:bg-black/70 backdrop-blur-sm rounded-full transition duration-200 border border-white/20"
                                            title="Ver en pantalla completa">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Controles de navegación -->
                    @if($pet->photos->count() > 1)
                        <!-- Botón anterior -->
                        <button onclick="previousSlide()" 
                                class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 backdrop-blur-sm text-white p-2 rounded-full transition duration-200 z-10 border border-white/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Botón siguiente -->
                        <button onclick="nextSlide()" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 backdrop-blur-sm text-white p-2 rounded-full transition duration-200 z-10 border border-white/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        
                        <!-- Indicadores de posición -->
                        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
                            @foreach($pet->photos as $index => $photo)
                                <button onclick="goToSlide({{ $index }})" 
                                        class="w-3 h-3 rounded-full transition duration-200 {{ $index === 0 ? 'bg-white' : 'bg-white/50 hover:bg-white/75' }}" 
                                        data-indicator="{{ $index }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <!-- Thumbnails -->
                @if($pet->photos->count() > 1)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Todas las fotos
                        </h3>
                        <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                            @foreach($pet->photos as $index => $photo)
                                <button onclick="goToSlide({{ $index }})" 
                                        class="relative group thumbnail-btn {{ $index === 0 ? 'ring-2 ring-blue-500' : '' }}" 
                                        data-thumb="{{ $index }}">
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                         alt="Miniatura {{ $index + 1 }}"
                                         class="w-full h-16 object-cover rounded-lg shadow-sm group-hover:shadow-md transition duration-200">
                                    
                                    <!-- Overlay de selección -->
                                    <div class="absolute inset-0 bg-blue-500/20 opacity-0 group-hover:opacity-100 rounded-lg transition duration-200"></div>
                                </button>
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

    <!-- Modal de pantalla completa -->
    @if($pet->photos && $pet->photos->count() > 0)
    <div id="fullscreenModal" class="fixed inset-0 bg-black/95 backdrop-blur-sm z-50 hidden overflow-auto">
        <!-- Botón cerrar -->
        <button onclick="closeFullscreen()" 
                class="fixed top-4 right-4 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition duration-200 z-60 backdrop-blur-sm border border-white/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Contenedor principal con scroll -->
        <div class="min-h-full flex items-center justify-center p-4">
            <!-- Imagen en pantalla completa -->
            <img id="fullscreenImage" 
                 src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                 alt="Foto de {{ $pet->name }}" 
                 class="max-w-none w-auto h-auto min-w-[50vw] min-h-[50vh] object-contain rounded-lg shadow-2xl cursor-grab active:cursor-grabbing"
                 style="max-width: 95vw; max-height: none;">
        </div>
        
        <!-- Controles de navegación en pantalla completa -->
        @if($pet->photos->count() > 1)
            <button onclick="previousSlideFullscreen()" 
                    class="fixed left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition duration-200 backdrop-blur-sm border border-white/20 z-60">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button onclick="nextSlideFullscreen()" 
                    class="fixed right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition duration-200 backdrop-blur-sm border border-white/20 z-60">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        @endif
        
        <!-- Información en la parte inferior -->
        <div class="fixed bottom-4 left-1/2 transform -translate-x-1/2 text-center z-60">
            <div class="bg-black/50 backdrop-blur-sm text-white px-4 py-2 rounded-lg border border-white/20">
                <p class="font-semibold">{{ $pet->name }}</p>
                <span id="fullscreenCounter" class="text-sm opacity-90">
                    1 de {{ $pet->photos->count() }}
                </span>
            </div>
        </div>
        
        <!-- Instrucciones -->
        <div class="fixed top-4 left-4 text-white/70 text-sm bg-black/30 backdrop-blur-sm px-3 py-2 rounded-lg z-60">
            <p>ESC para cerrar • ←→ para navegar • Scroll para zoom</p>
        </div>
    </div>
    @endif
</div>

<script>
let currentSlide = 0;
const totalSlides = {{ $pet->photos ? $pet->photos->count() : 0 }};

// Función para ir a un slide específico
function goToSlide(index) {
    // Ocultar slide actual
    const currentItem = document.querySelector(`[data-slide="${currentSlide}"]`);
    if (currentItem) {
        currentItem.classList.add('translate-x-full');
    }
    
    // Mostrar nuevo slide
    const newItem = document.querySelector(`[data-slide="${index}"]`);
    if (newItem) {
        newItem.classList.remove('translate-x-full');
        newItem.classList.remove('-translate-x-full');
    }
    
    currentSlide = index;
    updateCarouselUI();
}

// Función para ir al slide anterior
function previousSlide() {
    const prevIndex = (currentSlide - 1 + totalSlides) % totalSlides;
    
    // Animar salida hacia la derecha
    const currentItem = document.querySelector(`[data-slide="${currentSlide}"]`);
    if (currentItem) {
        currentItem.classList.add('translate-x-full');
    }
    
    // Animar entrada desde la izquierda
    const prevItem = document.querySelector(`[data-slide="${prevIndex}"]`);
    if (prevItem) {
        prevItem.classList.add('-translate-x-full');
        prevItem.classList.remove('translate-x-full');
        setTimeout(() => {
            prevItem.classList.remove('-translate-x-full');
        }, 10);
    }
    
    currentSlide = prevIndex;
    updateCarouselUI();
}

// Función para ir al slide siguiente
function nextSlide() {
    const nextIndex = (currentSlide + 1) % totalSlides;
    
    // Animar salida hacia la izquierda
    const currentItem = document.querySelector(`[data-slide="${currentSlide}"]`);
    if (currentItem) {
        currentItem.classList.add('-translate-x-full');
    }
    
    // Animar entrada desde la derecha
    const nextItem = document.querySelector(`[data-slide="${nextIndex}"]`);
    if (nextItem) {
        nextItem.classList.add('translate-x-full');
        nextItem.classList.remove('-translate-x-full');
        setTimeout(() => {
            nextItem.classList.remove('translate-x-full');
        }, 10);
    }
    
    currentSlide = nextIndex;
    updateCarouselUI();
}

// Actualizar UI del carrusel
function updateCarouselUI() {
    // Actualizar caption
    const caption = document.getElementById('photoCaption');
    if (caption) {
        caption.textContent = `Foto ${currentSlide + 1} de ${totalSlides}`;
    }
    
    // Actualizar indicadores
    document.querySelectorAll('[data-indicator]').forEach((indicator, index) => {
        if (index === currentSlide) {
            indicator.classList.add('bg-white');
            indicator.classList.remove('bg-white/50');
        } else {
            indicator.classList.add('bg-white/50');
            indicator.classList.remove('bg-white');
        }
    });
    
    // Actualizar thumbnails
    document.querySelectorAll('[data-thumb]').forEach((thumb, index) => {
        if (index === currentSlide) {
            thumb.classList.add('ring-2', 'ring-blue-500');
        } else {
            thumb.classList.remove('ring-2', 'ring-blue-500');
        }
    });
}

// Pantalla completa
function toggleFullscreen() {
    const modal = document.getElementById('fullscreenModal');
    const fullscreenImage = document.getElementById('fullscreenImage');
    const currentImage = document.querySelector(`[data-slide="${currentSlide}"] img`);
    
    if (modal && fullscreenImage && currentImage) {
        fullscreenImage.src = currentImage.src;
        modal.classList.remove('hidden');
        updateFullscreenCounter();
        // Permitir scroll en el modal pero bloquear scroll del fondo
        document.body.style.position = 'fixed';
        document.body.style.top = `-${window.scrollY}px`;
        document.body.style.width = '100%';
    }
}

function closeFullscreen() {
    const modal = document.getElementById('fullscreenModal');
    if (modal) {
        modal.classList.add('hidden');
        // Restaurar scroll del fondo
        const scrollY = document.body.style.top;
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.width = '';
        window.scrollTo(0, parseInt(scrollY || '0') * -1);
    }
}

function previousSlideFullscreen() {
    previousSlide();
    const fullscreenImage = document.getElementById('fullscreenImage');
    const currentImage = document.querySelector(`[data-slide="${currentSlide}"] img`);
    if (fullscreenImage && currentImage) {
        fullscreenImage.src = currentImage.src;
        updateFullscreenCounter();
    }
}

function nextSlideFullscreen() {
    nextSlide();
    const fullscreenImage = document.getElementById('fullscreenImage');
    const currentImage = document.querySelector(`[data-slide="${currentSlide}"] img`);
    if (fullscreenImage && currentImage) {
        fullscreenImage.src = currentImage.src;
        updateFullscreenCounter();
    }
}

function updateFullscreenCounter() {
    const counter = document.getElementById('fullscreenCounter');
    if (counter) {
        counter.textContent = `${currentSlide + 1} de ${totalSlides}`;
    }
}

// Navegación con teclado
document.addEventListener('keydown', function(e) {
    const fullscreenModal = document.getElementById('fullscreenModal');
    const isFullscreen = fullscreenModal && !fullscreenModal.classList.contains('hidden');
    
    switch(e.key) {
        case 'Escape':
            if (isFullscreen) {
                closeFullscreen();
            }
            break;
        case 'ArrowLeft':
            if (isFullscreen) {
                previousSlideFullscreen();
            } else {
                previousSlide();
            }
            break;
        case 'ArrowRight':
            if (isFullscreen) {
                nextSlideFullscreen();
            } else {
                nextSlide();
            }
            break;
        case ' ':
        case 'f':
        case 'F':
            e.preventDefault();
            if (isFullscreen) {
                closeFullscreen();
            } else {
                toggleFullscreen();
            }
            break;
    }
});

// Auto-play opcional (descomenta para activar)
/*
setInterval(() => {
    const fullscreenModal = document.getElementById('fullscreenModal');
    if (!fullscreenModal || fullscreenModal.classList.contains('hidden')) {
        nextSlide();
    }
}, 5000);
*/
</script>

@endsection