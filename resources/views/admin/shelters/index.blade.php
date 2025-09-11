<x-app-layout :pageTitle="'Administrar Refugios'" :metaDescription="'Gestiona todos los refugios de la plataforma VitalDoggy.'">
    <x-slot name="header">
        <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
            Administrar Refugios
        </h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            Gestiona todos los refugios de la plataforma VitalDoggy.
        </p>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb Navigation -->
            <x-admin-breadcrumb 
                :items="[]"
                currentPage="Administrar Refugios" />

            <!-- Header del Dashboard -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                        Refugios VitalDoggy
                    </span>
                </h1>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto mb-8">
                    Sistema completo para gestionar todos los refugios de la plataforma y supervisar su estado.
                </p>
                <a href="{{ route('admin.shelters.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-8 py-4 rounded-2xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 font-semibold shadow-lg">
                    <i class="fas fa-plus mr-3 text-lg"></i>Crear Nuevo Refugio
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Total Refugios -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Refugios</p>
                            <p class="text-3xl font-bold text-[#751629] dark:text-primary">{{ $shelters->count() }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">En la plataforma</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 rounded-xl">
                            <i class="fas fa-home text-2xl text-[#751629] dark:text-[#f56e5c]"></i>
                        </div>
                    </div>
                </div>

                <!-- Refugios Activos -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Refugios Activos</p>
                            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $shelters->where('status', 'active')->count() }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400">Operando normalmente</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl">
                            <i class="fas fa-check-circle text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Refugios Inactivos -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Refugios Inactivos</p>
                            <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $shelters->where('status', 'inactive')->count() }}</p>
                            <p class="text-xs text-red-600 dark:text-red-400">Requieren atención</p>
                        </div>
                        <div class="p-3 bg-gradient-to-br from-red-500/20 to-pink-500/20 rounded-xl">
                            <i class="fas fa-exclamation-triangle text-2xl text-red-600 dark:text-red-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shelters Table -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 border-b border-gray-200/50 dark:border-gray-700/50">
                    <h2 class="text-2xl font-bold mb-2 bg-gradient-to-r from-[#751629] to-[#f56e5c] bg-clip-text text-transparent dark:from-primary dark:to-accent">
                        Lista de Refugios
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Administra y supervisa todos los refugios registrados en la plataforma
                    </p>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Información</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Contacto</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Estadísticas</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                            @forelse($shelters as $shelter)
                            <tr class="hover:bg-gradient-to-r hover:from-gray-50/50 hover:to-gray-100/50 dark:hover:from-gray-700/30 dark:hover:to-gray-600/30 transition-all duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-600 dark:to-gray-700 shadow-md">
                                        @if($shelter->hasImage())
                                            <img src="{{ $shelter->image_url }}" alt="{{ $shelter->name }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-home text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $shelter->name }}</div>
                                        <div class="text-gray-600 dark:text-gray-300 text-sm">{{ $shelter->address }}</div>
                                        <div class="text-gray-500 dark:text-gray-400 text-sm">{{ $shelter->city }}</div>
                                        <div class="text-gray-700 dark:text-gray-200 text-sm mt-1 flex items-center">
                                            <i class="fas fa-users mr-2 text-[#751629] dark:text-[#f56e5c]"></i>
                                            Capacidad: {{ $shelter->capacity ?? 'No especificada' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="text-gray-700 dark:text-gray-200 text-sm flex items-center">
                                            <i class="fas fa-envelope mr-2 text-[#f56e5c] dark:text-[#6b1f11] w-4"></i>
                                            {{ $shelter->email ?? 'No especificado' }}
                                        </div>
                                        <div class="text-gray-700 dark:text-gray-200 text-sm flex items-center">
                                            <i class="fas fa-phone mr-2 text-[#6b1f11] dark:text-[#751629] w-4"></i>
                                            {{ $shelter->phone ?? 'No especificado' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <div class="text-gray-700 dark:text-gray-200 text-sm flex items-center">
                                            <i class="fas fa-dog mr-2 text-[#751629] dark:text-[#f56e5c] w-4"></i>
                                            {{ $shelter->pets_count ?? 0 }} mascotas
                                        </div>
                                        <div class="text-gray-700 dark:text-gray-200 text-sm flex items-center">
                                            <i class="fas fa-user-tie mr-2 text-[#f56e5c] dark:text-[#6b1f11] w-4"></i>
                                            {{ $shelter->caretakers_count ?? 0 }} cuidadores
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.shelters.toggle-status', $shelter) }}" method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de cambiar el estado de este refugio?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105
                                                       {{ $shelter->status === 'active' 
                                                          ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white hover:from-green-600 hover:to-emerald-600' 
                                                          : 'bg-gradient-to-r from-red-500 to-pink-500 text-white hover:from-red-600 hover:to-pink-600' }}">
                                            @if($shelter->status === 'active')
                                                <i class="fas fa-check mr-2"></i>Activo
                                            @else
                                                <i class="fas fa-times mr-2"></i>Inactivo
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.shelters.show', $shelter) }}" 
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye text-lg"></i>
                                        </a>
                                        <a href="{{ route('admin.shelters.edit', $shelter) }}" 
                                           class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-200 p-2 rounded-lg hover:bg-yellow-50 dark:hover:bg-yellow-900/30" 
                                           title="Editar">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <!-- Solo cambiar estado, no eliminar refugios -->
                                        <form action="{{ route('admin.shelters.toggle-status', $shelter) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    onclick="return confirm('¿Estás seguro de {{ $shelter->status === 'active' ? 'desactivar' : 'activar' }} este refugio?')"
                                                    class="transition-colors duration-200 p-2 rounded-lg {{ $shelter->status === 'active' ? 'text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/30' : 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/30' }}" 
                                                    title="{{ $shelter->status === 'active' ? 'Desactivar refugio' : 'Activar refugio' }}">
                                                <i class="fas {{ $shelter->status === 'active' ? 'fa-ban' : 'fa-check-circle' }} text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <div class="mx-auto w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-home text-3xl text-gray-400 dark:text-gray-500"></i>
                                        </div>
                                        <div class="text-xl font-medium mb-2 text-gray-700 dark:text-gray-300">No hay refugios registrados</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Comienza creando el primer refugio de la plataforma</div>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back to Dashboard -->
            <div class="mt-12 text-center">
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-300 hover:text-[#751629] dark:hover:text-[#f56e5c] transition-colors duration-200 font-medium">
                    <i class="fas fa-arrow-left mr-3"></i>
                    Volver al Panel de Administración
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
