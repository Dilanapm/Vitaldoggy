<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'VitalDoggy te ayuda a adoptar mascotas.' }}">

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
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Modo oscuro automático -->
    <script>
        // Verificar preferencia guardada en localStorage
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="font-sans antialiased">
    <div class="relative min-h-screen">
        <!-- Fondo gradient principal -->
        <div class="fixed inset-0 -z-20">
            <div class="absolute inset-0 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11]"></div>
        </div>

        <!-- Navigation Component -->
        <livewire:navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="relative bg-white/85 dark:bg-gray-900/85 backdrop-blur-md shadow-xl border-b border-white/30 dark:border-gray-700/50">
                <!-- Gradient overlay sutil para el header -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#751629]/5 via-[#f56e5c]/5 to-[#6b1f11]/5 dark:from-[#751629]/10 dark:via-[#f56e5c]/10 dark:to-[#6b1f11]/10"></div>
                
                <!-- Contenido del header -->
                <div class="relative max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="text-gray-800 dark:text-gray-100">
                        {{ $header }}
                    </div>
                </div>
                
                <!-- Línea decorativa inferior -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] opacity-60"></div>
            </header>
        @endif

        <!-- Page Content con overlay blanco para legibilidad -->
        <main class="relative">
            <div class="relative bg-white/75 dark:bg-gray-900/75 backdrop-blur-sm min-h-screen">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer Component (sin overlay) -->
        <div class="relative z-20">
            <x-footer />
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

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
</body>

</html>
