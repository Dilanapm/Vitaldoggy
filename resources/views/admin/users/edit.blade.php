<x-app-layout :pageTitle="'Editar Usuario'" :metaDescription="'Editar información del usuario en VitalDoggy.'">
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                Editar Usuario
            </h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">
                Modificar información del usuario {{ $user->name }}
            </p>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Breadcrumb Navigation -->
            <x-admin-breadcrumb 
                :items="[
                    ['label' => 'Gestión de Usuarios', 'url' => route('admin.users.index')]
                ]"
                currentPage="Editar Usuario" />

            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 border-b border-gray-200/30 dark:border-gray-700/30">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Información del Usuario</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Modifica los campos necesarios para actualizar el usuario.
                    </p>
                </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                               placeholder="Juan Pérez">
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre de Usuario <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" id="username" required
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                               placeholder="usuario123">
                        @error('username')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo letras, números y guiones bajos.</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Correo Electrónico <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                               placeholder="usuario@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Teléfono
                        </label>
                        <input type="tel" name="phone" id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                               placeholder="(123) 456-7890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dirección
                        </label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $user->address) }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                               placeholder="Calle 123, Colonia Centro">
                        @error('address')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shelter Assignment (dinámico según el rol) -->
                    <div id="shelter-assignment-container" class="{{ $user->role === 'caretaker' ? '' : 'hidden' }}">
                        <label for="shelter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-building mr-1 text-[#751629] dark:text-[#f56e5c]"></i>Refugio Asignado <span class="text-red-500">*</span>
                        </label>
                        <select name="shelter_id" id="shelter_id"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                                {{ $user->role === 'caretaker' ? 'required' : '' }}>
                            <option value="">Seleccionar refugio...</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter->id }}" 
                                        {{ old('shelter_id', $user->shelter_id) == $shelter->id ? 'selected' : '' }}>
                                    {{ $shelter->name }} - {{ $shelter->location }}
                                </option>
                            @endforeach
                        </select>
                        @error('shelter_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Los cuidadores deben estar asignados a un refugio específico
                        </p>
                    </div>

                    <!-- Current Shelter (solo mostrar cuando no es cuidador) -->
                    <div id="current-shelter-display" class="{{ $user->role !== 'caretaker' ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Refugio Actual
                        </label>
                        <div class="flex items-center px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-xl">
                            @if($user->shelter_id && $user->shelter)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">
                                    <i class="fas fa-building mr-1"></i>{{ $user->shelter->name }}
                                </span>
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">
                                    <i class="fas fa-info-circle mr-1"></i>Sin refugio asignado
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Solo los cuidadores requieren asignación de refugio
                        </p>
                    </div>

                    <!-- Status -->
                    @can('changeStatus', $user)
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado de la Cuenta <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200">
                            <option value="active" {{ old('status', $user->is_active ? 'active' : 'inactive') === 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status', $user->is_active ? 'active' : 'inactive') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado de la Cuenta
                        </label>
                        <div class="flex items-center px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-xl">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' }}">
                                <i class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            <i class="fas fa-info-circle mr-1"></i>No tienes permisos para cambiar el estado de este usuario
                        </p>
                    </div>
                    @endcan

                    <!-- Current Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Rol Actual
                        </label>
                        <div class="flex items-center px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-xl">
                            @php
                                $roleConfig = [
                                    'admin' => ['label' => 'Administrador', 'color' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300', 'icon' => 'fas fa-crown'],
                                    'caretaker' => ['label' => 'Cuidador', 'color' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300', 'icon' => 'fas fa-paw'],
                                    'user' => ['label' => 'Usuario', 'color' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300', 'icon' => 'fas fa-user'],
                                ];
                                $currentRoleConfig = $roleConfig[$user->role] ?? $roleConfig['user'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $currentRoleConfig['color'] }}">
                                <i class="{{ $currentRoleConfig['icon'] }} mr-1"></i>{{ $currentRoleConfig['label'] }}
                            </span>
                        </div>
                    </div>

                    <!-- User Achievements -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Logros del Usuario
                        </label>
                        <div class="flex flex-wrap gap-2 px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-xl min-h-[50px]">
                            @php
                                $achievements = $user->getAchievements();
                                $achievementConfig = [
                                    'adoptante' => ['label' => 'Adoptante', 'color' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300', 'icon' => 'fas fa-home'],
                                    'donador' => ['label' => 'Donador', 'color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300', 'icon' => 'fas fa-heart'],
                                    'voluntario' => ['label' => 'Voluntario', 'color' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300', 'icon' => 'fas fa-hands-helping'],
                                ];
                            @endphp
                            
                            @if(!empty($achievements))
                                @foreach($achievements as $achievement)
                                    @if(isset($achievementConfig[$achievement]))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $achievementConfig[$achievement]['color'] }}">
                                            <i class="{{ $achievementConfig[$achievement]['icon'] }} mr-1"></i>{{ $achievementConfig[$achievement]['label'] }}
                                        </span>
                                    @endif
                                @endforeach
                            @else
                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">
                                    <i class="fas fa-info-circle mr-1"></i>Sin logros desbloqueados aún
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                            <i class="fas fa-star mr-1"></i>Los logros se desbloquean automáticamente cuando el usuario realiza ciertas acciones
                        </p>
                    </div>

                    <!-- Role Management (solo para administradores) -->
                    @can('manageRoles', $user)
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-user-shield mr-1 text-[#751629] dark:text-[#f56e5c]"></i>Cambiar Rol
                        </label>
                        <select name="role" id="role"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200">
                            @foreach($roleConfig as $roleKey => $roleInfo)
                                <option value="{{ $roleKey }}" {{ $user->role === $roleKey ? 'selected' : '' }}>
                                    {{ $roleInfo['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
                            <i class="fas fa-info-circle mr-1"></i>Solo puedes cambiar el rol principal. Los logros no se pueden modificar manualmente.
                        </p>
                        @error('role')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    @endcan

                    <!-- Password Change Section -->
                    <div class="md:col-span-2 border-t border-gray-200/50 dark:border-gray-700/50 pt-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">
                            <i class="fas fa-key mr-2 text-[#751629] dark:text-[#f56e5c]"></i>Cambiar Contraseña (opcional)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Nueva Contraseña
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                                       placeholder="Dejar en blanco para mantener actual">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:border-[#751629] focus:ring-[#751629] focus:ring-1 transition-all duration-200"
                                       placeholder="Confirmar nueva contraseña">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-white/20">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-200 font-medium">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-semibold">
                        <i class="fas fa-save mr-2"></i>Actualizar Usuario
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Estilos para transiciones suaves -->
    <style>
        #shelter-assignment-container, #current-shelter-display {
            transition: all 0.3s ease-in-out;
        }
        
        #shelter-assignment-container.hidden, #current-shelter-display.hidden {
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
        }
        
        #shelter-assignment-container:not(.hidden), #current-shelter-display:not(.hidden) {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- Script para manejar la selección de roles y refugios -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.querySelector('select[name="role"]');
            const shelterContainer = document.getElementById('shelter-assignment-container');
            const currentShelterDisplay = document.getElementById('current-shelter-display');
            const shelterSelect = document.getElementById('shelter_id');
            
            if (roleSelect && shelterContainer && currentShelterDisplay && shelterSelect) {
                // Función para manejar el cambio de rol
                function handleRoleChange() {
                    const selectedRole = roleSelect.value;
                    
                    if (selectedRole === 'caretaker') {
                        // Mostrar selector de refugio y hacer requerido
                        shelterContainer.classList.remove('hidden');
                        currentShelterDisplay.classList.add('hidden');
                        shelterSelect.required = true;
                        
                        showNotification('Los cuidadores requieren asignación de refugio', 'info');
                    } else {
                        // Ocultar selector de refugio y quitar requerido
                        shelterContainer.classList.add('hidden');
                        currentShelterDisplay.classList.remove('hidden');
                        shelterSelect.required = false;
                        shelterSelect.value = ''; // Limpiar selección
                        
                        if (selectedRole === 'admin') {
                            showNotification('¡Cuidado! Estás asignando permisos de administrador', 'warning');
                        } else if (selectedRole === 'user') {
                            showNotification('Los usuarios no requieren asignación de refugio', 'info');
                        }
                    }
                }
                
                // Ejecutar al cargar la página
                handleRoleChange();
                
                // Ejecutar cuando cambie el rol
                roleSelect.addEventListener('change', handleRoleChange);
            }
            
            function showNotification(message, type = 'info') {
                // Crear notificación
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full max-w-sm ${
                    type === 'warning' ? 'bg-yellow-100 border border-yellow-400 text-yellow-700' : 
                    type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' : 
                    'bg-blue-100 border border-blue-400 text-blue-700'
                }`;
                
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'} mr-2"></i>
                        <span class="text-sm">${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-current opacity-50 hover:opacity-75">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Mostrar notificación
                setTimeout(() => notification.classList.remove('translate-x-full'), 100);
                
                // Ocultar automáticamente después de 4 segundos
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 4000);
            }
        });
    </script>
</x-app-layout>
