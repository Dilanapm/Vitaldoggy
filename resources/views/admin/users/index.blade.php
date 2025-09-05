<x-app-layout :pageTitle="'Gestión de Usuarios'" :metaDescription="'Administra todos los usuarios de VitalDoggy.'">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                    Gestión de Usuarios
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Administra todos los usuarios registrados en la plataforma.
                </p>
            </div>
            <a href="{{ route('admin.users.create') }}" 
               class="bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-6 py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-medium">
                <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
                Crear Usuario
            </a>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Estadísticas de Usuarios -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#751629] dark:text-primary">{{ $users->total() }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Total Usuarios</div>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $userStats['by_status']['active'] ?? 0 }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Activos</div>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $userStats['by_status']['inactive'] ?? 0 }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Inactivos</div>
                    </div>
                </div>
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-[#f56e5c] dark:text-accent">{{ $userStats['by_role']['admin'] ?? 0 }}</div>
                        <div class="text-gray-600 dark:text-gray-300">Administradores</div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 border-b border-gray-200/30 dark:border-gray-700/30">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Lista de Usuarios</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Refugio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Registro</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/30 dark:divide-gray-700/30">
                            @foreach($users as $user)
                                <tr class="hover:bg-white/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#751629] to-[#f56e5c] flex items-center justify-center text-white font-bold">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                               ($user->role === 'caretaker' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                               'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $user->shelter->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $user->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Toggle Status -->
                                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg transition-colors {{ $user->is_active ? 'text-red-600 hover:bg-red-100 dark:hover:bg-red-900/20' : 'text-green-600 hover:bg-green-100 dark:hover:bg-green-900/20' }}"
                                                        title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                                    @if($user->is_active)
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                            
                                            <!-- Edit User -->
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors"
                                               title="Editar">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="p-6 bg-gray-50/50 dark:bg-gray-700/50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
