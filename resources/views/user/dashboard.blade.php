<x-app-layout :pageTitle="'Panel de Usuario'" :metaDescription="'Gestiona tus adopciones y mascotas en VitalDoggy.'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
    </x-slot>

    <div class=" bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Bienvenido a <span class="text-primary dark:text-accent">VitalDoggy</span></h2>
                    <p class="mb-4">Desde aquí puedes gestionar tus adopciones y ver mascotas disponibles.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <a href="{{ route('pets.index') }}"
                           class="block p-6 bg-dark/50 hover:bg-dark/20 dark:bg-dark/20 dark:hover:bg-dark/40 rounded-lg transition duration-200 border border-primary/20 dark:border-primary/40 shadow-sm">
                            <h3 class="text-lg font-semibold text-primary dark:text-orange-400">Mascotas Disponibles</h3>
                            <p class="text-primary dark:text-gray-200">Encuentra tu nuevo compañero</p>
                        </a>

                        <a href="#"
                           class="block p-6 bg-secondary/10 hover:bg-secondary/20 dark:bg-secondary/30 dark:hover:bg-secondary/40 rounded-lg transition duration-200 border border-secondary/20 dark:border-secondary/40 shadow-sm">
                            <h3 class="text-lg font-semibold text-secondary dark:text-orange-400">Mis Adopciones</h3>
                            <p class="text-secondary dark:text-gray-200">Revisa el estado de tus solicitudes</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>