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
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="relative min-h-screen">
        <!-- Fondo gradient principal -->
        <div class="fixed inset-0 -z-20">
            <div class="absolute inset-0 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11]"></div>
        </div>
        
        <!-- Navigation Component -->
        <livewire:navigation />

        <!-- Page Heading (opcional) -->
        @hasSection('header')
            <header class="relative bg-white/85 dark:bg-gray-900/85 backdrop-blur-md shadow-xl border-b border-white/30 dark:border-gray-700/50">
                <!-- Gradient overlay sutil para el header -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#751629]/5 via-[#f56e5c]/5 to-[#6b1f11]/5 dark:from-[#751629]/10 dark:via-[#f56e5c]/10 dark:to-[#6b1f11]/10"></div>
                
                <!-- Contenido del header -->
                <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="text-gray-800 dark:text-gray-100">
                        @yield('header')
                    </div>
                </div>
                
                <!-- Línea decorativa inferior -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] opacity-60"></div>
            </header>
        @endif

        <!-- Main Content con overlay mejorado para legibilidad -->
        <main class="relative">
            <div class="relative bg-white/75 dark:bg-gray-900/75 backdrop-blur-sm">
                @yield('content')
            </div>
        </main>

        <!-- Footer Component (sin overlay) -->
        <div class="relative z-20">
            <x-footer />
        </div>
    </div>

    <!-- Scripts Component -->
    <x-scripts />
    
    <!-- Script para toggle de modo oscuro -->
    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        function setupDarkModeToggle() {
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleMobile = document.getElementById('theme-toggle-mobile');
            if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
            if (themeToggleMobile) themeToggleMobile.addEventListener('click', toggleTheme);
        }

        // Ejecutar después de que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', setupDarkModeToggle);
    </script>
    
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
    
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
