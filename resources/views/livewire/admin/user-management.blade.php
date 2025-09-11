<div>
    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="font-semibold text-xl text-gray-800 dark:text-white">
                        Panel de Control
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        Administra todos los usuarios registrados en la plataforma.
                    </p>
                </div>
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white px-6 py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-medium">
                    <i class="fas fa-user-plus mr-2"></i>
                    Crear Usuario
                </a>
            </div>

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

            <!-- Filtros -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Buscar Usuario
                        </label>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               id="search"
                               placeholder="Buscar por nombre, email o username..."
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#751629] focus:ring-[#751629]">
                    </div>
                    <div>
                        <label for="roleFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Filtrar por Rol
                        </label>
                        <select wire:model.live="roleFilter" 
                                id="roleFilter"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#751629] focus:ring-[#751629]">
                            <option value="">Todos los roles</option>
                            <option value="admin">Administrador</option>
                            <option value="caretaker">Cuidador</option>
                            <option value="adopter">Adoptante</option>
                        </select>
                    </div>
                    <div>
                        <label for="statusFilter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Filtrar por Estado
                        </label>
                        <select wire:model.live="statusFilter" 
                                id="statusFilter"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-[#751629] focus:ring-[#751629]">
                            <option value="">Todos los estados</option>
                            <option value="active">Activos</option>
                            <option value="inactive">Inactivos</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Loading indicator -->
            <div wire:loading.delay class="flex justify-center items-center py-4">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#751629]"></div>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden" wire:loading.remove.delay>
                <div class="p-6 bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 border-b border-gray-200/30 dark:border-gray-700/30">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">Lista de Usuarios</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50/50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-user mr-2 text-[#751629] dark:text-primary"></i>Usuario
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-shield-alt mr-2 text-[#751629] dark:text-primary"></i>Rol
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-toggle-on mr-2 text-[#751629] dark:text-primary"></i>Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-home mr-2 text-[#751629] dark:text-primary"></i>Refugio
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-calendar-alt mr-2 text-[#751629] dark:text-primary"></i>Registro
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <i class="fas fa-cogs mr-2 text-[#751629] dark:text-primary"></i>Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/30 dark:divide-gray-700/30">
                            @forelse($users as $user)
                                <tr class="hover:bg-white/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($user->profile_photo_path)
                                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                                         alt="{{ $user->name }}" 
                                                         class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#751629] to-[#f56e5c] flex items-center justify-center text-white font-bold">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                                @if($user->username)
                                                    <div class="text-xs text-gray-400 dark:text-gray-500"> {{ $user->username }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                                               ($user->role === 'caretaker' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 
                                               'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">
                                            @if($user->role === 'admin')
                                                <i class="fas fa-crown mr-2"></i>
                                            @elseif($user->role === 'caretaker')
                                                <i class="fas fa-user-tie mr-2"></i>
                                            @else
                                                <i class="fas fa-user mr-2"></i>
                                            @endif
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                            <i class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-2"></i>
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        <div class="flex items-center">
                                            <i class="fas fa-building text-orange-500 mr-2"></i>
                                            {{ $user->shelter->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                            {{ $user->created_at->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Toggle Status -->
                                            <button type="button" 
                                                    onclick="handleUserStatusToggle({{ $user->id }}, '{{ $user->name }}', {{ $user->is_active ? 'true' : 'false' }})"
                                                    class="inline-flex items-center px-3 py-2 rounded-lg transition-colors {{ $user->is_active ? 'bg-red-100 hover:bg-red-200 dark:bg-red-800/20 dark:hover:bg-red-700/30 text-red-700 dark:text-red-300' : 'bg-green-100 hover:bg-green-200 dark:bg-green-800/20 dark:hover:bg-green-700/30 text-green-700 dark:text-green-300' }}"
                                                    title="{{ $user->is_active ? 'Desactivar' : 'Activar' }}">
                                                <i class="fas {{ $user->is_active ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                            
                                            <!-- Edit User -->
                                            <a href="{{ route('admin.users.edit', $user) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-800/20 dark:hover:bg-blue-700/30 text-blue-700 dark:text-blue-300 rounded-lg transition-colors"
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <i class="fas fa-users text-6xl text-gray-300 dark:text-gray-600"></i>
                                            <div class="text-center">
                                                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">No se encontraron usuarios</h3>
                                                <p class="text-gray-500 dark:text-gray-400">Intenta ajustar los filtros de búsqueda.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if($users->hasPages())
                    <div class="p-6 bg-gray-50/50 dark:bg-gray-700/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Función para manejar el toggle de estado del usuario
        function handleUserStatusToggle(userId, userName, currentStatus) {
            if (typeof confirmUserStatusToggle === 'function') {
                confirmUserStatusToggle(userId, userName, currentStatus)
                    .then((result) => {
                        if (result.isConfirmed) {
                            @this.call('toggleUserStatus', userId);
                        }
                    });
            } else {
                // Fallback si la función no está disponible
                if (confirm(`¿Estás seguro de ${currentStatus ? 'desactivar' : 'activar'} a ${userName}?`)) {
                    @this.call('toggleUserStatus', userId);
                }
            }
        }

        // Escuchar eventos de Livewire
        document.addEventListener('livewire:init', function() {
            Livewire.on('show-alert', (event) => {
                console.log('Evento show-alert recibido:', event);
                
                // El evento puede venir como array o objeto
                let data = event;
                if (Array.isArray(event) && event.length > 0) {
                    data = event[0];
                }
                
                const { type, title, message } = data;
                
                // Usar la función global showToast si está disponible
                if (typeof showToast === 'function') {
                    showToast(type, title, message);
                } else if (typeof Swal !== 'undefined') {
                    // Usar Swal directamente
                    Swal.fire({
                        icon: type,
                        title: title,
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'dark:bg-gray-800 dark:text-white'
                        }
                    });
                } else {
                    // Fallback final
                    alert(`${title}: ${message}`);
                }
            });
        });
    </script>
    </script>
</div>
