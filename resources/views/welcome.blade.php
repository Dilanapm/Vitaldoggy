<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-gray-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VitalDoggy - Refugio y Adopción de Mascotas</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: '#FF6B6B',
                            secondary: '#4ECDC4',
                            accent: '#FFD166',
                            dark: '#1A535C',
                        }
                    }
                },
                darkMode: 'class',
            }

            // Detectar modo oscuro del sistema y aplicarlo
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        </script>

        <style>
            /* Mejorar la visibilidad del texto en modo oscuro */
            .dark .dark\:text-improved-white {
                color: rgba(255, 255, 255, 0.95);
            }
            .dark .dark\:bg-improved-gray {
                background-color: rgba(17, 24, 39, 0.95);
            }
        </style>
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900">
        <div class="relative min-h-screen">
            <!-- Hero background -->
            <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-secondary/20 dark:from-primary/5 dark:to-secondary/5 -z-10"></div>
            
            <!-- Navigation -->
            <header class="relative z-10">
                <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <svg class="w-10 h-10 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
                        </svg>
                        <span class="text-2xl font-bold text-dark dark:text-white">VitalDoggy</span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle Button -->
                        <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                            <!-- Sun icon (shown in dark mode) -->
                            <svg id="sun-icon" class="hidden dark:block w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                            <!-- Moon icon (shown in light mode) -->
                            <svg id="moon-icon" class="block dark:hidden w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                        </button>

                        @if (Route::has('login'))
                            <div class="flex space-x-2">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-white/80 text-dark hover:bg-white transition duration-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                        Iniciar sesión
                                    </a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200">
                                            Registrarse
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </nav>
            </header>

            <!-- Hero Section -->
            <section class="py-12 lg:py-20 container mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6">
                        <h1 class="text-4xl lg:text-5xl font-bold text-dark dark:text-white leading-tight">
                            Encuentra un nuevo amigo y dale una segunda oportunidad
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-300">
                            En VitalDoggy conectamos a mascotas que necesitan un hogar con personas que desean adoptar. Conoce nuestros albergues asociados y cambia una vida para siempre.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">
                                Adoptar una mascota
                            </a>
                            <a href="#servicios" class="px-6 py-3 rounded-lg bg-white border border-primary text-primary font-medium hover:bg-gray-50 transition duration-200 dark:bg-gray-800 dark:border-primary dark:hover:bg-gray-700">
                                Conocer más
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Perro feliz" class="w-full h-80 object-cover object-center">
                        </div>
                        <div class="absolute -bottom-6 -right-6 bg-accent rounded-lg p-4 shadow-lg">
                            <p class="text-dark font-semibold">+500 adopciones exitosas</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Servicios Section -->
            <section id="servicios" class="py-16 bg-white dark:bg-gray-800">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-dark dark:text-white">Nuestros Servicios</h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                            Ofrecemos una variedad de servicios para asegurar que las mascotas encuentren un hogar amoroso y permanente.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Servicio 1 -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="rounded-full bg-primary/20 dark:bg-primary/10 p-4 inline-block mb-4">
                                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M10,2H14A1,1 0 0,1 15,3V5H9V3A1,1 0 0,1 10,2M21,7V13A5,5 0 0,1 16,18H8A5,5 0 0,1 3,13V7H21M11.75,9V11.5H9V13.5H11.75V16H13.25V13.5H16V11.5H13.25V9H11.75Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">Adopción de Mascotas</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Encuentra tu compañero perfecto entre nuestras mascotas disponibles para adopción.
                            </p>
                        </div>

                        <!-- Servicio 2 -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="rounded-full bg-secondary/20 dark:bg-secondary/10 p-4 inline-block mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,21.35L10.55,20.03C5.4,15.36 2,12.27 2,8.5C2,5.41 4.42,3 7.5,3C9.24,3 10.91,3.81 12,5.08C13.09,3.81 14.76,3 16.5,3C19.58,3 22,5.41 22,8.5C22,12.27 18.6,15.36 13.45,20.03L12,21.35Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">Donaciones</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Ayúdanos a mantener nuestros albergues con donaciones que salvan vidas.
                            </p>
                        </div>

                        <!-- Servicio 3 -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="rounded-full bg-accent/20 dark:bg-accent/10 p-4 inline-block mb-4">
                                <svg class="w-8 h-8 text-accent" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,3L2,12H5V20H19V12H22L12,3M12,8.75A2.25,2.25 0 0,1 14.25,11A2.25,2.25 0 0,1 12,13.25A2.25,2.25 0 0,1 9.75,11A2.25,2.25 0 0,1 12,8.75M12,15C13.5,15 16.5,15.75 16.5,17.25V18H7.5V17.25C7.5,15.75 10.5,15 12,15Z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">Voluntariado</h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Únete a nuestro equipo de voluntarios y ayuda directamente a las mascotas.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Estadísticas -->
            <section class="py-12 bg-gradient-to-r from-primary to-secondary">
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div class="bg-white/90 dark:bg-gray-800/90 rounded-lg p-6">
                            <p class="text-3xl font-bold text-primary">500+</p>
                            <p class="text-dark dark:text-white font-medium">Adopciones</p>
                        </div>
                        <div class="bg-white/90 dark:bg-gray-800/90 rounded-lg p-6">
                            <p class="text-3xl font-bold text-secondary">15</p>
                            <p class="text-dark dark:text-white font-medium">Albergues</p>
                        </div>
                        <div class="bg-white/90 dark:bg-gray-800/90 rounded-lg p-6">
                            <p class="text-3xl font-bold text-accent">120+</p>
                            <p class="text-dark dark:text-white font-medium">Voluntarios</p>
                        </div>
                        <div class="bg-white/90 dark:bg-gray-800/90 rounded-lg p-6">
                            <p class="text-3xl font-bold text-dark dark:text-primary">50+</p>
                            <p class="text-dark dark:text-white font-medium">Donantes</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonios -->
            <section class="py-16 bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-6">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-dark dark:text-white">Historias de Adopción</h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                            Conoce algunas de las historias de éxito de nuestras adopciones.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Testimonio 1 -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-primary/20 dark:bg-primary/10 flex items-center justify-center mr-4">
                                    <span class="text-primary font-bold">JG</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Juan García</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Max</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">
                                "Adoptar a Max fue la mejor decisión. El proceso fue muy sencillo y el equipo de VitalDoggy me ayudó en cada paso. Ahora tengo un compañero fiel."
                            </p>
                        </div>

                        <!-- Testimonio 2 -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-secondary/20 dark:bg-secondary/10 flex items-center justify-center mr-4">
                                    <span class="text-secondary font-bold">AR</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Ana Rodríguez</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Luna</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">
                                "Luna llegó a mi vida cuando más la necesitaba. El proceso de adopción fue fácil y ahora tenemos una conexión increíble. Gracias VitalDoggy."
                            </p>
                        </div>

                        <!-- Testimonio 3 -->
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 rounded-full bg-accent/20 dark:bg-accent/10 flex items-center justify-center mr-4">
                                    <span class="text-accent font-bold">CM</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Carlos Méndez</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Rocky</p>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300">
                                "Rocky era un perro tímido cuando lo adopté, pero ahora es el alma de la fiesta. Esta plataforma hace un trabajo increíble conectando mascotas con familias."
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="py-16 bg-dark dark:bg-black">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-3xl font-bold text-white mb-6">Cambia una vida hoy</h2>
                    <p class="text-gray-300 mb-8 max-w-2xl mx-auto">
                        Adopta, dona o únete como voluntario. Cada pequeña acción puede hacer una gran diferencia en la vida de una mascota.
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">
                            Regístrate ahora
                        </a>
                        <a href="#" class="px-6 py-3 rounded-lg bg-transparent border border-white text-white font-medium hover:bg-white/10 transition duration-200">
                            Conocer albergues
                        </a>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="bg-gray-900 dark:bg-black text-white py-12">
                <div class="container mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-8 h-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
                                </svg>
                                <span class="text-xl font-bold">VitalDoggy</span>
                            </div>
                            <p class="text-gray-400">
                                Conectando mascotas con hogares amorosos desde 2023.
                            </p>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4">Enlaces rápidos</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-primary transition">Inicio</a></li>
                                <li><a href="#" class="hover:text-primary transition">Adopciones</a></li>
                                <li><a href="#" class="hover:text-primary transition">Donaciones</a></li>
                                <li><a href="#" class="hover:text-primary transition">Albergues</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4">Legal</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li><a href="#" class="hover:text-primary transition">Términos de uso</a></li>
                                <li><a href="#" class="hover:text-primary transition">Política de privacidad</a></li>
                                <li><a href="#" class="hover:text-primary transition">Cookies</a></li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                            <ul class="space-y-2 text-gray-400">
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                                    </svg>
                                    <span>contacto@vitaldoggy.com</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
                                    </svg>
                                    <span>+123 456 7890</span>
                                </li>
                            </ul>
                            <div class="mt-4 flex space-x-4">
                                <a href="#" class="text-gray-400 hover:text-primary">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 3,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16 6,17.26 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.79C20.33,8.6 20.33,8.42 20.32,8.23C21.16,7.63 21.88,6.87 22.46,6Z" />
                                    </svg>
                                </a>
                                <a href="#" class="text-gray-400 hover:text-primary">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
                        <p>© {{ date('Y') }} VitalDoggy. Todos los derechos reservados.</p>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Script para alternar entre modos claro y oscuro -->
        <script>
            const themeToggle = document.getElementById('theme-toggle');
            
            themeToggle.addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                
                // Opcional: guardar preferencia en localStorage
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.theme = 'dark';
                } else {
                    localStorage.theme = 'light';
                }
            });
            
            // Verificar preferencia guardada en localStorage
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </body>
</html>