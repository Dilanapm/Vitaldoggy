<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark:bg-gray-900">

<head>
    <title>@yield('title', 'VitalDoggy - Refugio y Adopción de Mascotas')</title>
    <meta charset="utf-8">
    <meta name="description" content="@yield('description', 'VitalDoggy te ayuda a encontrar y adoptar mascotas en refugios. Únete a nuestra comunidad y cambia una vida.')">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('meta')

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
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
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

    @yield('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <div class="relative min-h-screen">
        @yield('background', '')
        
        <!-- Navigation Component -->
        <x-navigation />

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer Component -->
        <x-footer />
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
                            
                            // Calcular posición con offset para header fijo si existe
                            const headerHeight = 80; // Ajusta según tu header
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

    @yield('scripts')
</body>

</html>
