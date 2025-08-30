<x-app-layout :pageTitle="'Panel de Usuario'" :metaDescription="'Gestiona tus adopciones y mascotas en VitalDoggy.'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
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
                        Bienvenido a VitalDoggy
                    </span>
                </h1>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                    Desde aquí puedes gestionar tus adopciones y descubrir mascotas que necesitan un hogar lleno de amor.
                </p>
            </div>

            <!-- Cards principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Card Mascotas Disponibles -->
                <a href="{{ route('pets.index') }}"
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#751629]/90 to-[#f56e5c]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">🐕</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Mascotas Disponibles</h3>
                        <p class="text-white/90">Encuentra tu nuevo compañero perfecto</p>
                        <div class="mt-4 flex items-center text-sm font-medium">
                            <span>Explorar mascotas</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Card Mis Solicitudes -->
                <a href="{{ route('adoption.index') }}"
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#f56e5c]/90 to-[#6b1f11]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">📋</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Mis Solicitudes</h3>
                        <p class="text-white/90">Revisa el estado de tus adopciones</p>
                        <div class="mt-4 flex items-center text-sm font-medium">
                            <span>Ver solicitudes</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Card Perfil -->
                <a href="{{ route('profile.edit') }}"
                   class="group relative overflow-hidden rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-br from-[#6b1f11]/90 to-[#751629]/80"></div>
                    <div class="relative p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                            <span class="text-2xl font-bold opacity-20">👤</span>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">Mi Perfil</h3>
                        <p class="text-white/90">Gestiona tu información personal</p>
                        <div class="mt-4 flex items-center text-sm font-medium">
                            <span>Editar perfil</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8 mb-8">
                <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                    Estadísticas Rápidas
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gradient-to-br from-[#751629]/10 to-[#f56e5c]/10 rounded-2xl border border-[#751629]/20">
                        <div class="text-3xl font-bold text-[#751629] dark:text-primary mb-2">12</div>
                        <div class="text-gray-600 dark:text-gray-300">Mascotas Disponibles</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-[#f56e5c]/10 to-[#6b1f11]/10 rounded-2xl border border-[#f56e5c]/20">
                        <div class="text-3xl font-bold text-[#f56e5c] dark:text-accent mb-2">3</div>
                        <div class="text-gray-600 dark:text-gray-300">Adopciones Exitosas</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-[#6b1f11]/10 to-[#751629]/10 rounded-2xl border border-[#6b1f11]/20">
                        <div class="text-3xl font-bold text-[#6b1f11] dark:text-secondary mb-2">5</div>
                        <div class="text-gray-600 dark:text-gray-300">Refugios Asociados</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>