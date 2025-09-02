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
        /* Scroll suave optimizado */
        html {
            scroll-behavior: smooth;
        }

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
        <livewire:navigation />

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
                            class="px-6 py-3 rounded-lg bg-dark text-white font-medium hover:bg-primary/90 transition duration-200">
                                Adoptar una mascota
                        </a>
                        <a href="#testimonios"
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
        <section id="testimonios" class="py-16 bg-gray-50 dark:bg-gray-900">
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
                <p class="text-gray-700 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                    Adopta, dona o únete como voluntario. Cada pequeña acción puede hacer una gran diferencia en la vida
                    de una mascota.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}"
                        class="px-6 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">
                            Adoptar una mascota
                    </a>
                    <a href="{{ route('shelters.index') }}"
                        class="px-6 py-3 rounded-lg bg-transparent border border-white text-white font-medium hover:bg-white/10 transition duration-200">
                        Conocer albergues
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
                <!-- Footer Component -->
        <x-footer />
    </div>
    </div>

    <!-- Scripts Component -->
    <x-scripts />

    <script>
        // Scroll suave optimizado con JavaScript para mayor control
        document.addEventListener('DOMContentLoaded', function() {
            // Interceptar enlaces a secciones de la misma página
            const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
            
            smoothScrollLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.getAttribute('href');
                    
                    // Solo procesar si es un ID válido
                    if (targetId !== '#' && targetId.length > 1) {
                        const targetElement = document.querySelector(targetId);
                        
                        if (targetElement) {
                            e.preventDefault();
                            
                            // Calcular posición con offset para header/navigation
                            const headerHeight = 80; // Ajusta según tu navigation
                            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                            
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
