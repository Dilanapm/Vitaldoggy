<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Bienvenido a VitalDoggy</h2>
                    <p class="mb-4">Desde aquí puedes gestionar tus adopciones y ver mascotas disponibles.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <a href="#" class="block p-6 bg-amber-100 hover:bg-amber-200 rounded-lg transition">
                            <h3 class="text-lg font-semibold">Mascotas Disponibles</h3>
                            <p>Encuentra tu nuevo compañero</p>
                        </a>
                        
                        <a href="#" class="block p-6 bg-teal-100 hover:bg-teal-200 rounded-lg transition">
                            <h3 class="text-lg font-semibold">Mis Adopciones</h3>
                            <p>Revisa el estado de tus solicitudes</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>