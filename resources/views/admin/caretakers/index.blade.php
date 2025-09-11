<x-app-layout :pageTitle="'Gestión de Cuidadores'" :metaDescription="'Administra todos los cuidadores de VitalDoggy.'">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                    Gestión de Cuidadores
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Administra todos los cuidadores registrados en la plataforma.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumb Navigation -->
            <x-admin-breadcrumb 
                :items="[]"
                currentPage="Gestión de Cuidadores" />

            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                        Cuidadores VitalDoggy
                    </span>
                </h1>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto mb-8">
                    Sistema completo para gestionar todos los cuidadores de la plataforma y supervisar su estado.
                </p>
                <a href="{{ route('admin.caretakers.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-8 py-4 rounded-2xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 font-semibold shadow-lg">
                    <i class="fas fa-user-plus mr-3 text-lg"></i>Crear Nuevo Cuidador
                </a>
            </div>
            <div class="bg-white/95 backdrop-blur-sm dark:bg-gray-800/95 rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
                <div class="p-8">
                    @if (session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 dark:from-green-800/20 dark:to-green-900/20 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" role="alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <span class="font-medium text-green-800 dark:text-green-300">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-xl">
                        <table class="min-w-full bg-white/50 dark:bg-gray-800/50 border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-primary/10 dark:to-secondary/10">
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-user mr-2 text-[#751629] dark:text-primary"></i>Nombre
                                    </th>
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-envelope mr-2 text-[#751629] dark:text-primary"></i>Email
                                    </th>
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-phone mr-2 text-[#751629] dark:text-primary"></i>Teléfono
                                    </th>
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-home mr-2 text-[#751629] dark:text-primary"></i>Albergue
                                    </th>
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-toggle-on mr-2 text-[#751629] dark:text-primary"></i>Estado
                                    </th>
                                    <th class="px-6 py-4 border-b border-gray-200/50 dark:border-gray-700/50 text-left text-sm font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        <i class="fas fa-cogs mr-2 text-[#751629] dark:text-primary"></i>Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                @forelse ($caretakers as $caretaker)
                                    <tr class="hover:bg-gradient-to-r hover:from-[#751629]/5 hover:to-[#f56e5c]/5 dark:hover:from-primary/5 dark:hover:to-secondary/5 transition-all duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie text-[#751629] dark:text-primary mr-3"></i>
                                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $caretaker->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-at text-gray-500 mr-2"></i>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $caretaker->email }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-phone-alt text-blue-500 mr-2"></i>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $caretaker->phone }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class="fas fa-building text-orange-500 mr-2"></i>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $caretaker->shelter->name ?? 'Sin albergue' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex items-center text-sm font-medium rounded-full {{ $caretaker->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-800/20 dark:text-red-300' }}">
                                                <i class="fas {{ $caretaker->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                                {{ $caretaker->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('admin.caretakers.edit', $caretaker) }}" 
                                                   class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-800/20 dark:hover:bg-blue-700/30 text-blue-700 dark:text-blue-300 rounded-lg transition-colors duration-200"
                                                   title="Editar cuidador">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <form action="{{ route('admin.caretakers.toggle-status', $caretaker) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-2 {{ $caretaker->is_active ? 'bg-red-100 hover:bg-red-200 dark:bg-red-800/20 dark:hover:bg-red-700/30 text-red-700 dark:text-red-300' : 'bg-green-100 hover:bg-green-200 dark:bg-green-800/20 dark:hover:bg-green-700/30 text-green-700 dark:text-green-300' }} rounded-lg transition-colors duration-200"
                                                            title="{{ $caretaker->is_active ? 'Desactivar cuidador' : 'Activar cuidador' }}">
                                                        <i class="fas {{ $caretaker->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center space-y-4">
                                                <i class="fas fa-users text-6xl text-gray-300 dark:text-gray-600"></i>
                                                <div class="text-center">
                                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No hay cuidadores registrados</h3>
                                                    <p class="text-gray-500 dark:text-gray-400">Comienza creando el primer cuidador para tu sistema.</p>
                                                </div>
                                                <a href="{{ route('admin.caretakers.create') }}" 
                                                   class="inline-flex items-center bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-6 py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-medium">
                                                    <i class="fas fa-user-plus mr-2"></i>Crear Primer Cuidador
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($caretakers->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl p-4 border border-gray-200/50 dark:border-gray-700/50">
                                {{ $caretakers->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>