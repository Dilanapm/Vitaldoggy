<x-app-layout :pageTitle="'Panel de Usuario'" :metaDescription="'Gestiona tus adopciones y mascotas en VitalDoggy.'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Bienvenido a <span class="text-primary dark:text-primary">VitalDoggy</span></h2>
                    <p class="mb-4">Desde aquí puedes gestionar tus adopciones y ver mascotas disponibles.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <a href="#"
                           class="block p-6 bg-amber-100 hover:bg-amber-200 dark:bg-amber-900/70 dark:hover:bg-amber-900/90 rounded-lg transition duration-200 border border-amber-200 dark:border-amber-800 shadow-sm">
                            <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100">Mascotas Disponibles</h3>
                            <p class="text-amber-800 dark:text-amber-200">Encuentra tu nuevo compañero</p>
                        </a>
                        
                        <a href="#"
                           class="block p-6 bg-teal-100 hover:bg-teal-200 dark:bg-teal-900/70 dark:hover:bg-teal-900/90 rounded-lg transition duration-200 border border-teal-200 dark:border-teal-800 shadow-sm">
                            <h3 class="text-lg font-semibold text-teal-900 dark:text-teal-100">Mis Adopciones</h3>
                            <p class="text-teal-800 dark:text-teal-200">Revisa el estado de tus solicitudes</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>