<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel Administrativo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">Bienvenido al Panel de Administración</h2>
                    <p class="mb-4">Desde aquí puedes gestionar todas las funciones administrativas de VitalDoggy.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        <a href="{{ route('admin.shelters') }}" class="block p-6 bg-blue-100 hover:bg-blue-200 rounded-lg transition">
                            <h3 class="text-lg font-semibold">Albergues</h3>
                            <p>Gestiona los albergues registrados</p>
                        </a>
                        
                        <a href="#" class="block p-6 bg-green-100 hover:bg-green-200 rounded-lg transition">
                            <h3 class="text-lg font-semibold">Usuarios</h3>
                            <p>Administra usuarios del sistema</p>
                        </a>
                        
                        <a href="#" class="block p-6 bg-purple-100 hover:bg-purple-200 rounded-lg transition">
                            <h3 class="text-lg font-semibold">Estadísticas</h3>
                            <p>Visualiza reportes y estadísticas</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>