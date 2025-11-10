<x-app-layout :pageTitle="'Gestión de Solicitudes de Adopción'" :metaDescription="'Panel administrativo para gestionar todas las solicitudes de adopción del sistema.'">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                Gestión de Solicitudes de Adopción
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                Panel Administrativo - Todas las Solicitudes
            </div>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <!-- Estadísticas Globales -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total General</p>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pendientes</p>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['under_review'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">En Revisión</p>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['approved'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Aprobadas</p>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['rejected'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Rechazadas</p>
                    </div>
                </div>
            </div>

            <!-- Estadísticas por Refugio -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Resumen por Refugio</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($shelterStats as $shelter)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-600/50 rounded-xl p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $shelter->name }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Mascotas:</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $shelter->total_pets }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Disponibles:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">{{ $shelter->available_pets }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Adoptadas:</span>
                                    <span class="font-medium text-blue-600 dark:text-blue-400">{{ $shelter->adopted_pets }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600 dark:text-gray-400">Pendientes:</span>
                                    <span class="font-medium text-yellow-600 dark:text-yellow-400">{{ $shelter->pending_applications }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Filtros -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Búsqueda -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Buscar
                        </label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nombre, email, mascota o refugio..."
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-[#751629] focus:ring-[#751629]">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado
                        </label>
                        <select id="status" 
                                name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-[#751629] focus:ring-[#751629]">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>En Revisión</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>

                    <!-- Refugio -->
                    <div>
                        <label for="shelter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Refugio
                        </label>
                        <select id="shelter_id" 
                                name="shelter_id"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-[#751629] focus:ring-[#751629]">
                            <option value="">Todos los refugios</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter->id }}" {{ request('shelter_id') == $shelter->id ? 'selected' : '' }}>
                                    {{ $shelter->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label for="pet_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Mascota
                        </label>
                        <select id="pet_id" 
                                name="pet_id"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-[#751629] focus:ring-[#751629]">
                            <option value="">Todas las mascotas</option>
                            @foreach($pets as $pet)
                                <option value="{{ $pet->id }}" {{ request('pet_id') == $pet->id ? 'selected' : '' }}>
                                    {{ $pet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                                class="flex-1 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-4 py-2 rounded-lg hover:shadow-lg transition-all duration-300">
                            Filtrar
                        </button>
                        <a href="{{ route('admin.adoption-applications.index') }}"
                           class="flex-1 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Lista de Solicitudes -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
                @if($applications->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Adoptante</th>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Mascota</th>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Refugio</th>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($applications as $application)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-[#751629] to-[#f56e5c] flex items-center justify-center text-white font-bold">
                                                        {{ substr($application->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $application->user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $application->user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $application->pet->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ ucfirst($application->pet->type) }} • {{ $application->pet->breed }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $application->pet->shelter->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $application->pet->shelter->city }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($application->status)
                                                @case('pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200">
                                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                                                        Pendiente
                                                    </span>
                                                    @break
                                                @case('under_review')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                                        En Revisión
                                                    </span>
                                                    @break
                                                @case('approved')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                                        Aprobada
                                                    </span>
                                                    @break
                                                @case('rejected')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                                                        <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                                        Rechazada
                                                    </span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $application->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.adoption-applications.show', $application) }}"
                                                   class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-colors">
                                                    Ver
                                                </a>
                                                
                                                @if($application->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.adoption-applications.review', $application) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                                class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition-colors">
                                                            Revisar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50">
                        {{ $applications->appends(request()->except('page'))->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay solicitudes</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            @if(request()->hasAny(['search', 'status', 'shelter_id', 'pet_id']))
                                No se encontraron solicitudes con los filtros aplicados.
                            @else
                                Aún no hay solicitudes de adopción en el sistema.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>