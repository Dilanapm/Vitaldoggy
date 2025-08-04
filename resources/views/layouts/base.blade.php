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

        <!-- Footer -->
        @yield('footer', '')
    </div>

    <!-- Scripts Component -->
    <x-scripts />
    
    @yield('scripts')
</body>

</html>
