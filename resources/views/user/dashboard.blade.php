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
                    Tu Progreso en VitalDoggy
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-gradient-to-br from-[#751629]/10 to-[#f56e5c]/10 rounded-2xl border border-[#751629]/20">
                        <div class="text-3xl font-bold text-[#751629] dark:text-primary mb-2">{{ $userStats['total_applications'] }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Solicitudes Enviadas</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-[#f56e5c]/10 to-[#6b1f11]/10 rounded-2xl border border-[#f56e5c]/20">
                        <div class="text-3xl font-bold text-[#f56e5c] dark:text-accent mb-2">{{ $userStats['successful_adoptions'] }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Adopciones Exitosas</div>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-[#6b1f11]/10 to-[#751629]/10 rounded-2xl border border-[#6b1f11]/20">
                        <div class="text-3xl font-bold text-[#6b1f11] dark:text-secondary mb-2">{{ $userStats['pending_applications'] }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Solicitudes Pendientes</div>
                    </div>
                </div>
            </div>

            <!-- Sistema de Logros/Roles -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                            Desbloquea Nuevos Roles
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Completa actividades para desbloquear roles especiales y obtener nuevos privilegios
                        </p>
                    </div>
                    <div class="hidden md:block text-4xl">🏆</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($roleAchievements as $roleKey => $achievement)
                        <div class="relative overflow-hidden rounded-2xl border transition-all duration-300 hover:scale-105 
                            {{ $achievement['unlocked'] 
                                ? 'border-green-200 dark:border-green-600 bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20' 
                                : 'border-gray-200 dark:border-gray-600 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-700/50' }}">
                            
                            <!-- Badge de estado -->
                            <div class="absolute top-4 right-4 z-10">
                                @if($achievement['unlocked'])
                                    <div class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9l-5-4.87L19 2l-7 7-7-7L7 4.13 2 9l6.91-.74L12 2z"/>
                                        </svg>
                                        DESBLOQUEADO
                                    </div>
                                @else
                                    <div class="bg-gray-400 dark:bg-gray-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        BLOQUEADO
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <!-- Icono y título -->
                                <div class="flex items-center mb-4">
                                    <div class="text-4xl mr-4 {{ $achievement['unlocked'] ? '' : 'grayscale opacity-50' }}">
                                        {{ $achievement['icon'] }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold {{ $achievement['unlocked'] ? 'text-gray-800 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
                                            {{ $achievement['title'] }}
                                        </h3>
                                        <p class="text-sm {{ $achievement['unlocked'] ? 'text-gray-600 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500' }}">
                                            {{ $achievement['description'] }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Barra de progreso mejorada -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="{{ $achievement['unlocked'] ? 'text-gray-600 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500' }}">
                                            Progreso
                                        </span>
                                        <span class="font-bold {{ $achievement['progress'] >= 100 ? 'text-green-600' : ($achievement['progress'] >= 50 ? 'text-yellow-600' : 'text-gray-400 dark:text-gray-500') }}">
                                            {{ $achievement['progress'] }}%
                                            @if($achievement['progress'] >= 100)
                                                ✓
                                            @elseif($achievement['progress'] >= 50)
                                                ⚡
                                            @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 
                                            @if($achievement['progress'] >= 100)
                                                bg-gradient-to-r from-green-400 to-emerald-500
                                            @elseif($achievement['progress'] >= 50)
                                                bg-gradient-to-r from-yellow-400 to-orange-500
                                            @else
                                                bg-gradient-to-r from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-500
                                            @endif" 
                                             style="width: {{ $achievement['progress'] }}%">
                                        </div>
                                    </div>
                                </div>

                                <!-- Requisito -->
                                <!-- Requisito y progreso detallado -->
                                <div class="text-xs {{ $achievement['unlocked'] ? 'text-green-600 font-medium' : 'text-gray-500 dark:text-gray-400' }}">
                                    <div class="flex items-center mb-2">
                                        @if($achievement['unlocked'])
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                            </svg>
                                            ¡Completado!
                                        @else
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                                            </svg>
                                            {{ $achievement['requirement'] }}
                                        @endif
                                    </div>
                                    
                                    <!-- Mostrar pasos para adoptante -->
                                    @if($roleKey === 'adoptante' && !$achievement['unlocked'])
                                        <div class="mt-2 space-y-1">
                                            <div class="text-xs text-gray-400 dark:text-gray-500 font-medium mb-1">Pasos:</div>
                                            @if(isset($achievement['steps']))
                                                @foreach($achievement['steps'] as $step)
                                                    <div class="flex items-center text-xs">
                                                        @if($achievement['progress'] >= 50 && str_contains($step, '50%'))
                                                            <svg class="w-3 h-3 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                            </svg>
                                                        @elseif($achievement['progress'] >= 100 && str_contains($step, '100%'))
                                                            <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                            </svg>
                                                        @else
                                                            <div class="w-3 h-3 mr-1 border border-gray-300 dark:border-gray-600 rounded-full"></div>
                                                        @endif
                                                        <span class="{{ ($achievement['progress'] >= 50 && str_contains($step, '50%')) || ($achievement['progress'] >= 100 && str_contains($step, '100%')) ? 'text-gray-600 dark:text-gray-300' : 'text-gray-400 dark:text-gray-500' }}">
                                                            {{ $step }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </div>                                <!-- Efectos visuales para desbloqueado -->
                                @if($achievement['unlocked'])
                                    <div class="absolute inset-0 bg-gradient-to-br {{ $achievement['color'] }} opacity-5 pointer-events-none"></div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Call to action -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        ¡Sigue participando en VitalDoggy para desbloquear más roles y ayudar a más mascotas!
                    </p>
                    <a href="{{ route('pets.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white font-medium rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Explorar Mascotas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>