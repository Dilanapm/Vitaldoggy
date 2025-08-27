<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VitalDoggy') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Modo oscuro automático -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="h-full font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Columna del Logo (izquierda) - Oculta en móviles, visible en pantallas md y superiores -->
        <div class="hidden md:flex md:w-1/2 bg-primary/10 dark:bg-primary/5 flex-col justify-center items-center p-8">
            <div class="max-w-md mx-auto text-center">
                <!-- Logo Grande -->
                
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('logo.png') }}" alt="Logo VitalDoggy" class="w-40 h-40 object-contain">
                </div>
                
                <!-- Nombre de la App -->
                <h1 class="text-4xl font-bold text-dark dark:text-white mb-4">{{ config('app.name', 'VitalDoggy') }}</h1>
                
                <!-- Descripción -->
                <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
                    Conectamos mascotas con hogares amorosos. Encuentra tu compañero perfecto o ayúdanos a salvar vidas a través de donaciones.
                </p>
                
                <!-- Estadísticas -->
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <p class="text-2xl font-bold text-primary">500+</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Adopciones exitosas</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-sm">
                        <p class="text-2xl font-bold text-secondary">15</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Albergues asociados</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-auto text-center text-sm text-gray-600 dark:text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            </div>
        </div>
        
        <!-- Columna del Formulario (derecha) -->
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6">
            <!-- Toggle de modo oscuro -->
            <div class="absolute top-4 right-4">
                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <!-- Sol (visible en modo oscuro) -->
                    <svg id="sun-icon" class="hidden dark:block w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                    </svg>
                    <!-- Luna (visible en modo claro) -->
                    <svg id="moon-icon" class="block dark:hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Logo pequeño (solo visible en móviles) -->
            <div class="md:hidden flex items-center justify-center mb-6">
                <svg class="w-16 h-16 text-primary" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17,8C8,10 5.9,16.17 3.82,21.34L5.71,22L6.66,19.7C7.14,19.87 7.64,20 8,20C19,20 22,3 22,3C21,5 14,5.25 9,6.25C4,7.25 2,11.5 2,13.5C2,15.5 3.75,17.25 3.75,17.25C7,8 17,8 17,8Z"/>
                </svg>
                <span class="text-2xl font-bold ml-2 text-dark dark:text-white">{{ config('app.name', 'VitalDoggy') }}</span>
            </div>
            
            <!-- Contenedor del formulario -->
            <div class="w-full max-w-md px-6 py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
    
    <!-- Script para controlar el toggle -->
    <script>
        document.getElementById('theme-toggle').addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
</body>
</html>