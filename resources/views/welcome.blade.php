<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-gray-900">

<head>
    <title>VitalDoggy - Refugio y Adopción de Mascotas</title>
    <meta charset="utf-8">
    <meta name="description"
        content="VitalDoggy te ayuda a encontrar y adoptar mascotas en refugios. Únete a nuestra comunidad y cambia una vida.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- DATOS ESTRUCTURADOS SCHEMA.ORG -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "VitalDoggy",
      "url": "https://vitaldoggy.com",
      "description": "Refugio y adopción de mascotas."
    }
    </script>
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
                        primary: '#7C444F',
                        secondary: '#9F5255',
                        accent: '#E16A54',
                        dark: '#F39E60',
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
        <div
            class="absolute inset-0 -z-10
        bg-gradient-to-br
        from-[#751629]
        via-[#f56e5c] 
        via-70% 
        to-[#6b1f11]
        dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5">
        </div>


        <!-- Navigation Component -->
        <x-navigation />

        <!-- Hero Section -->
        <section class="py-12 lg:py-20 container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-4xl lg:text-5xl font-bold text-dark dark:text-white leading-tight">
                        Encuentra un nuevo amigo y dale una segunda oportunidad
                    </h1>
                    <p class="text-lg text-gray-200 dark:text-gray-300">
                        En VitalDoggy conectamos a mascotas que necesitan un hogar con personas que desean adoptar.
                        Conoce nuestros albergues asociados y cambia una vida para siempre.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}"
                            class="px-6 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">
                                Adoptar una mascota
                        </a>
                        <a href="#servicios"
                            class="px-6 py-3 rounded-lg bg-white border border-primary text-primary font-medium hover:bg-gray-50 transition duration-200 dark:bg-gray-800 dark:border-primary dark:hover:bg-gray-700">
                            Conocer más
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="Perro feliz" class="w-full h-80 object-cover object-center">
                    </div>
                    <div class="absolute -bottom-6 -right-6 bg-primary rounded-lg p-4 shadow-lg">
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
                        Ofrecemos una variedad de servicios para asegurar que las mascotas encuentren un hogar amoroso y
                        permanente.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Servicio 1 -->
                    <div
                        class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="rounded-full bg-primary/20 dark:bg-primary/10 p-4 inline-block mb-4">
                            <x-icons.medical-kit class="w-8 h-8 text-primary" />
                        </div>
                        <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">Adopción de Mascotas</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Encuentra tu compañero perfecto entre nuestras mascotas disponibles para adopción.
                        </p>
                    </div>

                    <!-- Servicio 2 -->
                    <div
                        class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="rounded-full bg-secondary/20 dark:bg-secondary/10 p-4 inline-block mb-4">
                            <x-icons.heart class="w-8 h-8 text-secondary" />
                        </div>
                        <h3 class="text-xl font-semibold text-dark dark:text-white mb-2">Donaciones</h3>
                        <p class="text-gray-600 dark:text-gray-300">
                            Ayúdanos a mantener nuestros albergues con donaciones que salvan vidas.
                        </p>
                    </div>

                    <!-- Servicio 3 -->
                    <div
                        class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="rounded-full bg-accent/20 dark:bg-accent/10 p-4 inline-block mb-4">
                            <x-icons.volunteer class="w-8 h-8 text-accent" />
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
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/20 dark:bg-primary/10 flex items-center justify-center mr-4">
                                <span class="text-primary font-bold">JG</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-dark dark:text-white">Juan García</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Max</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "Adoptar a Max fue la mejor decisión. El proceso fue muy sencillo y el equipo de VitalDoggy
                            me ayudó en cada paso. Ahora tengo un compañero fiel."
                        </p>
                    </div>

                    <!-- Testimonio 2 -->
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-secondary/20 dark:bg-secondary/10 flex items-center justify-center mr-4">
                                <span class="text-secondary font-bold">AR</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-dark dark:text-white">Ana Rodríguez</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Luna</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "Luna llegó a mi vida cuando más la necesitaba. El proceso de adopción fue fácil y ahora
                            tenemos una conexión increíble. Gracias VitalDoggy."
                        </p>
                    </div>

                    <!-- Testimonio 3 -->
                    <div
                        class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                        <div class="flex items-center mb-4">
                            <div
                                class="w-12 h-12 rounded-full bg-accent/20 dark:bg-accent/10 flex items-center justify-center mr-4">
                                <span class="text-accent font-bold">CM</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-dark dark:text-white">Carlos Méndez</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Adoptó a Rocky</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "Rocky era un perro tímido cuando lo adopté, pero ahora es el alma de la fiesta. Esta
                            plataforma hace un trabajo increíble conectando mascotas con familias."
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
                    Adopta, dona o únete como voluntario. Cada pequeña acción puede hacer una gran diferencia en la vida
                    de una mascota.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">
                            Adoptar una mascota
                    </a>
                    <a href="#"
                        class="px-6 py-3 rounded-lg bg-transparent border border-white text-white font-medium hover:bg-white/10 transition duration-200">
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
                            <img src="{{ asset('logo.png') }}" alt="Logo VitalDoggy" class="w-20 h-20 object-contain">
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
                            <li><a href="{{ route('pets.index') }}" class="hover:text-primary transition">Adopciones</a></li>
                            <li><a href="#" class="hover:text-primary transition">Donaciones</a></li>
                            <li><a href="#" class="hover:text-primary transition">Albergues</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-primary transition">Términos de uso</a></li>
                            <li><a href="#" class="hover:text-primary transition">Política de privacidad</a>
                            </li>
                            <li><a href="#" class="hover:text-primary transition">Cookies</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                                </svg>
                                <span>contacto@vitaldoggy.com</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
                                </svg>
                                <span>+123 456 7890</span>
                            </li>
                        </ul>
                        <div class="mt-4 flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-primary">
                                <x-icons.instagram class="w-6 h-6" />
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary">
                                <x-icons.twitter class="w-6 h-6" />
                            </a>
                            <a href="#" class="text-gray-400 hover:text-primary">
                                <x-icons.facebook class="w-6 h-6" />
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

    <!-- Scripts Component -->
    <x-scripts />
</body>

</html>
