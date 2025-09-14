<x-app-layout :pageTitle="'Dashboard del Cuidador'" :metaDescription="'Panel de control para gestionar tu refugio y mascotas.'">
    <x-slot name="header">
        <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
            Panel del Cuidador
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Gestiona las mascotas y operaciones de {{ Auth::user()->shelter ? Auth::user()->shelter->name : 'tu refugio' }}.
        </p>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                        Mi Refugio
                    </span>
                </h1>
                @if(Auth::user()->shelter)
                    <p class="text-xl text-gray-700 dark:text-gray-300 font-medium">
                        {{ Auth::user()->shelter->name }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">
                        {{ Auth::user()->shelter->address }}
                    </p>
                @endif
            </div>

            <!-- Estadísticas del Refugio -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Mascotas del Refugio -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Mis Mascotas</p>
                            <p class="text-3xl font-bold text-[#751629] dark:text-primary">{{ $stats['shelter_pets'] ?? 0 }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400">{{ $stats['available_pets'] ?? 0 }} disponibles</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#751629] dark:text-[#f56e5c]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1L13.5 2.5L16.17 5.17C15.24 5.06 14.32 5 13.4 5H10.6C9.68 5 8.76 5.06 7.83 5.17L10.5 2.5L9 1L3 7V9H1V11H3C3 16.55 7.45 21 13 21S23 16.55 23 11H21V9Z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes Pendientes -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Solicitudes Pendientes</p>
                            <p class="text-3xl font-bold text-[#f56e5c] dark:text-accent">{{ $stats['pending_applications'] ?? 0 }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $stats['applications_this_week'] ?? 0 }} esta semana</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#f56e5c]/20 to-[#6b1f11]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#f56e5c] dark:text-[#6b1f11]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Adopciones Exitosas -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Adopciones Exitosas</p>
                            <p class="text-3xl font-bold text-[#6b1f11] dark:text-secondary">{{ $stats['adopted_pets'] ?? 0 }}</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400">{{ $stats['adoptions_this_month'] ?? 0 }} este mes</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#6b1f11]/20 to-[#751629]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#6b1f11] dark:text-[#751629]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Capacidad del Refugio -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Capacidad</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['occupancy_percentage'] ?? 0 }}%</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stats['capacity'] ?? 0 }} espacios total</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 rounded-xl">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Crear Nueva Mascota -->
                <a href="{{ route('admin.pets.create') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#751629]/90 to-[#f56e5c]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">🐕</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Nueva Mascota</h3>
                        <p class="text-white/90 mb-4">Registrar una nueva mascota en el refugio</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Agregar mascota</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Gestionar Cuidadores -->
                <a href="{{ route('caretaker.caretakers.index') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#f56e5c]/90 to-[#6b1f11]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.38 8H16c-.8 0-1.56.31-2.12.88L12 10.75 10.12 8.88C9.56 8.31 8.8 8 8 8H5.62c-.75 0-1.42.49-1.58 1.37L1.5 16H4v6h16z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">👥</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Gestionar Cuidadores</h3>
                        <p class="text-white/90 mb-4">Administrar equipo de cuidadores del refugio</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Ver cuidadores</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Ver Solicitudes de Adopción -->
                <a href="{{ route('caretaker.adoption-applications.index') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#6b1f11]/90 to-[#751629]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">📋</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Solicitudes de Adopción</h3>
                        <p class="text-white/90 mb-4">Revisar y gestionar solicitudes pendientes</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Ver solicitudes</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Notificaciones y Alertas -->
            @if(isset($notifications) && count($notifications) > 0)
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                        Notificaciones Recientes
                    </h2>
                    @if(isset($stats['pending_applications']) && $stats['pending_applications'] > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                            <span class="w-2 h-2 bg-red-400 rounded-full mr-2 animate-pulse"></span>
                            {{ $stats['pending_applications'] }} pendientes
                        </span>
                    @endif
                </div>
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl">
                            <div class="text-2xl mr-4">{{ $notification['icon'] }}</div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200">{{ $notification['description'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $notification['date']->diffForHumans() }}</p>
                            </div>
                            @if(isset($notification['action_url']))
                                <a href="{{ $notification['action_url'] }}" 
                                   class="ml-4 inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[#751629] hover:bg-[#751629]/90 transition duration-150">
                                    Ver
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Acceso Rápido a Mascotas -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                        Acceso Rápido
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('pets.index') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="p-2 bg-blue-500 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">Ver Mis Mascotas</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Gestionar todas las mascotas</p>
                        </div>
                    </a>

                    <a href="{{ route('shelters.show', Auth::user()->shelter_id ?? 1) }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="p-2 bg-green-500 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">Mi Refugio</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Información del refugio</p>
                        </div>
                    </a>

                    <a href="{{ route('caretaker.caretakers.create') }}" 
                       class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="p-2 bg-purple-500 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">Agregar Cuidador</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Nuevo miembro del equipo</p>
                        </div>
                    </a>

                    <a href="#" 
                       class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl hover:shadow-lg transition-all duration-300">
                        <div class="p-2 bg-orange-500 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-200">Reportes</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Estadísticas detalladas</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>