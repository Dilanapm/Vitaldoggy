@extends('layouts.base')

@section('title', 'Refugios - VitalDoggy')
@section('description', 'Conoce nuestros refugios aliados que rescatan y cuidan mascotas en busca de un hogar.')

@section('content')
    <!-- Hero Section -->
    <div class="py-2 lg:py-2 container mx-auto px-6 dark:bg-gray-900/75">
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                    Nuestros Refugios Aliados
                </span>
            </h1>
            <p class="text-lg text-gray-800 dark:text-gray-300 max-w-3xl mx-auto">
                Conoce los refugios y albergues que trabajan incansablemente para rescatar, cuidar y encontrar hogares para mascotas abandonadas.
                Cada uno tiene una historia única y una misión compartida: salvar vidas.
            </p>
        </div>
    </div>

    <!-- Shelters Grid -->
    <div class="dark:bg-gray-900/75 py-2">
        <div class="container mx-auto px-6">
            @if($shelters->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($shelters as $shelter)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
                            <!-- Imagen del refugio -->
                            <div class="h-48 overflow-hidden">
                                @if($shelter->hasImage())
                                    <img src="{{ $shelter->image_url }}" 
                                         alt="{{ $shelter->name }}"
                                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full bg-gradient-to-r from-primary/20 to-secondary/20 flex items-center justify-center">
                                        <x-icons.heart class="w-16 h-16 text-primary" />
                                    </div>
                                @endif
                            </div>

                            <!-- Información del refugio -->
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">{{ $shelter->name }}</h3>
                                
                                <div class="flex items-center text-gray-600 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2C15.31,2 18,4.66 18,7.95C18,12.41 12,19 12,19S6,12.41 6,7.95C6,4.66 8.69,2 12,2M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6Z" />
                                    </svg>
                                    <span class="text-sm">{{ $shelter->city }}</span>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                    {{ Str::limit($shelter->description, 120) }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-primary">
                                        <x-icons.medical-kit class="w-4 h-4 mr-1" />
                                        <span class="text-sm font-medium">Capacidad: {{ $shelter->capacity }}</span>
                                    </div>
                                    
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        {{ $shelter->status_label }}
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('shelters.show', $shelter) }}" 
                                       class="w-full inline-block text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition duration-200">
                                        Ver mascotas
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-12 dark:bg-gray-900/75">
                    {{ $shelters->links() }}
                </div>
            @else
                <div class="text-center py-12 dark:bg-gray-900/75">
                    <x-icons.heart class="w-16 h-16 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-2">No hay refugios disponibles</h3>
                    <p class="text-gray-500 dark:text-gray-400">Próximamente tendremos más refugios aliados.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Call to Action - Solo para usuarios no autenticados -->
    @guest
        <section class="py-16 bg-gradient-to-r from-primary to-secondary">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-white mb-6">¿Tienes un refugio?</h2>
                <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                    Únete a nuestra red de refugios aliados y ayúdanos a conectar más mascotas con familias amorosas.
                </p>
                <a href="{{ route('register') }}" 
                   class="px-6 py-3 rounded-lg bg-white text-primary font-medium hover:bg-gray-100 transition duration-200">
                    Registrar mi refugio
                </a>
            </div>
        </section>
    @endguest
@endsection
