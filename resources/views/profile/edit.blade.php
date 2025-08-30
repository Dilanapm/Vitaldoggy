<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
            Configuración del Perfil
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Gestiona la información de tu cuenta y configuración de privacidad.
        </p>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background - igual que el dashboard -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad - igual que el dashboard -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        

            <div class="space-y-8">
                <!-- Información del Perfil -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm shadow-2xl border border-gray-200/30 dark:border-gray-700/30 rounded-3xl overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
                    <div class="bg-gradient-to-r from-[#751629]/15 via-[#f56e5c]/15 to-[#6b1f11]/15 dark:from-[#751629]/10 dark:via-[#f56e5c]/10 dark:to-[#6b1f11]/10 p-8 border-b border-gray-200/30 dark:border-gray-700/30">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 dark:from-[#751629]/30 dark:to-[#f56e5c]/30 rounded-xl backdrop-blur-sm mr-4">
                                <svg class="w-8 h-8 text-[#751629] dark:text-[#f56e5c]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                    Información Personal
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Actualiza tu información personal y dirección de correo electrónico.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm shadow-2xl border border-gray-200/30 dark:border-gray-700/30 rounded-3xl overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
                    <div class="bg-gradient-to-r from-[#f56e5c]/15 via-[#6b1f11]/15 to-[#751629]/15 dark:from-[#f56e5c]/10 dark:via-[#6b1f11]/10 dark:to-[#751629]/10 p-8 border-b border-gray-200/30 dark:border-gray-700/30">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-gradient-to-br from-[#f56e5c]/20 to-[#6b1f11]/20 dark:from-[#f56e5c]/30 dark:to-[#6b1f11]/30 rounded-xl backdrop-blur-sm mr-4">
                                <svg class="w-8 h-8 text-[#f56e5c] dark:text-[#6b1f11]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,17A2,2 0 0,0 14,15C14,13.89 13.1,13 12,13A2,2 0 0,0 10,15A2,2 0 0,0 12,17M18,8A2,2 0 0,1 20,10V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V10C4,8.89 4.9,8 6,8H7V6A5,5 0 0,1 12,1A5,5 0 0,1 17,6V8H18M12,3A3,3 0 0,0 9,6V8H15V6A3,3 0 0,0 12,3Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                    Seguridad de la Cuenta
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Mantén tu cuenta segura actualizando tu contraseña regularmente.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Eliminar Cuenta -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm shadow-2xl border border-red-200/30 dark:border-red-700/30 rounded-3xl overflow-hidden transform hover:scale-[1.01] transition-all duration-300">
                    <div class="bg-gradient-to-r from-red-100/50 via-red-50/50 to-red-100/50 dark:from-red-900/20 dark:via-red-800/20 dark:to-red-900/20 p-8 border-b border-red-200/30 dark:border-red-700/30">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-gradient-to-br from-red-100/60 to-red-200/60 dark:from-red-900/40 dark:to-red-800/40 rounded-xl backdrop-blur-sm mr-4">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                                    Zona Peligrosa
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300">
                                    Elimina permanentemente tu cuenta y todos los datos asociados.
                                </p>
                            </div>
                        </div>
                        <div class="bg-red-50/80 dark:bg-red-900/30 backdrop-blur-sm p-4 rounded-xl border border-red-200/50 dark:border-red-800/50">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,2L13.09,8.26L22,9L13.09,9.74L12,16L10.91,9.74L2,9L10.91,8.26L12,2Z" />
                                </svg>
                                <div class="text-sm">
                                    <p class="text-red-700 dark:text-red-300 font-medium">¡Atención!</p>
                                    <p class="text-red-600 dark:text-red-400 mt-1">
                                        Esta acción no se puede deshacer. Se eliminarán permanentemente todas tus solicitudes de adopción, historial y datos personales.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="mt-12">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-2xl p-8">
                    <h2 class="text-2xl font-bold mb-6 bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                        Acciones Rápidas
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <a href="{{ route('pets.index') }}" 
                           class="group p-6 bg-gradient-to-br from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 rounded-2xl border border-[#751629]/20 dark:border-[#f56e5c]/30 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-[#751629] dark:text-[#f56e5c] mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <span class="font-semibold text-gray-800 dark:text-white">Ver Mascotas</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors">
                                Explora todas las mascotas disponibles para adopción
                            </p>
                        </a>

                        <a href="{{ route('adoption.index') }}" 
                           class="group p-6 bg-gradient-to-br from-[#f56e5c]/10 to-[#6b1f11]/10 dark:from-[#f56e5c]/20 dark:to-[#6b1f11]/20 rounded-2xl border border-[#f56e5c]/20 dark:border-[#6b1f11]/30 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-[#f56e5c] dark:text-[#6b1f11] mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                                </svg>
                                <span class="font-semibold text-gray-800 dark:text-white">Mis Solicitudes</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors">
                                Revisa el estado de tus solicitudes de adopción
                            </p>
                        </a>

                        <a href="{{ route('user.dashboard') }}" 
                           class="group p-6 bg-gradient-to-br from-[#6b1f11]/10 to-[#751629]/10 dark:from-[#6b1f11]/20 dark:to-[#751629]/20 rounded-2xl border border-[#6b1f11]/20 dark:border-[#751629]/30 hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center mb-3">
                                <svg class="w-6 h-6 text-[#6b1f11] dark:text-[#751629] mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z" />
                                </svg>
                                <span class="font-semibold text-gray-800 dark:text-white">Dashboard</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors">
                                Volver al panel principal de usuario
                            </p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
