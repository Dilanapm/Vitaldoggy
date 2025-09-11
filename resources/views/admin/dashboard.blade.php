<x-app-layout :pageTitle="'Panel de Administrador'" :metaDescription="'Gestiona los albergues, usuarios y estadísticas de VitalDoggy.'">
    <x-slot name="header">
        <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
            Panel Administrativo
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Controla y gestiona toda la plataforma VitalDoggy desde aquí.
        </p>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            {{-- <!-- Breadcrumb Navigation - Solo mostramos en el dashboard que estamos en inicio -->
            <div class="mb-6">
                <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center px-3 py-2 text-[#751629] dark:text-[#f56e5c] font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                        </svg>
                        Dashboard Administrativo
                    </div>
                </nav>
            </div> --}}

            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                        Administración VitalDoggy
                    </span>
                </h1>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                    Sistema completo para gestionar usuarios, refugios, cuidadores y supervisar todas las adopciones de la plataforma.
                </p>
            </div>

            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Total Usuarios -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Usuarios</p>
                            <p class="text-3xl font-bold text-[#751629] dark:text-primary">{{ $stats['total_users'] ?? 0 }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400">+{{ $stats['users_this_month'] ?? 0 }} este mes</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#751629] dark:text-[#f56e5c]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Refugios -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Refugios Activos</p>
                            <p class="text-3xl font-bold text-[#f56e5c] dark:text-accent">{{ $stats['active_shelters'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">de {{ $stats['total_shelters'] ?? 0 }} total</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#f56e5c]/20 to-[#6b1f11]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#f56e5c] dark:text-[#6b1f11]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Mascotas Disponibles -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Mascotas Disponibles</p>
                            <p class="text-3xl font-bold text-[#6b1f11] dark:text-secondary">{{ $stats['available_pets'] ?? 0 }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $stats['adopted_pets'] ?? 0 }} adoptadas</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#6b1f11]/20 to-[#751629]/20 rounded-xl">
                            <svg class="w-8 h-8 text-[#6b1f11] dark:text-[#751629]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Solicitudes Pendientes -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Solicitudes Pendientes</p>
                            <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending_applications'] ?? 0 }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $stats['applications_this_month'] ?? 0 }} este mes</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-yellow-100 to-orange-100 dark:from-yellow-900/30 dark:to-orange-900/30 rounded-xl">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Gestión de Usuarios -->
                <a href="{{ route('admin.users.index') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#751629]/90 to-[#f56e5c]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 4c0-1.11.89-2 2-2s2 .89 2 2-.89 2-2 2-2-.89-2-2zm4 18v-6h2.5l-2.54-7.63A1.5 1.5 0 0 0 18.38 8H16c-.8 0-1.56.31-2.12.88L12 10.75 10.12 8.88C9.56 8.31 8.8 8 8 8H5.62c-.75 0-1.42.49-1.58 1.37L1.5 16H4v6h16z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">👥</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Gestionar Usuarios</h3>
                        <p class="text-white/90 mb-4">Crear, editar y administrar todos los usuarios del sistema</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Ver usuarios</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Gestión de Refugios -->
                <a href="{{ route('admin.shelters.index') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#f56e5c]/90 to-[#6b1f11]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10,20V14H14V20H19V12H22L12,3L2,12H5V20H10Z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">🏠</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Gestionar Refugios</h3>
                        <p class="text-white/90 mb-4">Administrar refugios y sus capacidades</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Ver refugios</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Gestión de Cuidadores -->
                <a href="{{ route('admin.caretakers.index') }}" 
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#6b1f11]/90 to-[#751629]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">🤝</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Gestionar Cuidadores</h3>
                        <p class="text-white/90 mb-4">Administrar cuidadores y sus asignaciones</p>
                        <div class="flex items-center text-sm font-medium">
                            <span>Ver cuidadores</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Actividades Recientes -->
            @if(isset($recentActivities) && count($recentActivities) > 0)
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8">
                <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                    Actividad Reciente
                </h2>
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl">
                            <div class="text-2xl mr-4">{{ $activity['icon'] }}</div>
                            <div class="flex-1">
                                <p class="text-gray-800 dark:text-gray-200">{{ $activity['description'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $activity['date']->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>