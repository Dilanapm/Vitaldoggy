<x-app-layout :pageTitle="'Crear Usuario'" :metaDescription="'Crear un nuevo usuario en VitalDoggy.'">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                    Crear Nuevo Usuario
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    Agrega un nuevo usuario al sistema con rol específico.
                </p>
            </div>
            <a href="{{ route('admin.users') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl transition-all duration-300 font-medium">
                ← Volver a Usuarios
            </a>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden">
                <div class="p-8 bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 border-b border-gray-200/30 dark:border-gray-700/30">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Información del Usuario</h3>
                    <p class="text-gray-600 dark:text-gray-300 mt-2">
                        Complete todos los campos para crear el nuevo usuario.
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="p-8 space-y-6">
                    @csrf

                    <!-- Información Básica -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre Completo *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="Ingrese el nombre completo"
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre de Usuario *
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="usuario123"
                                   required>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Solo letras, números y guiones bajos. Mínimo 3 caracteres.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Correo Electrónico *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="usuario@ejemplo.com"
                                   required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contraseña -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contraseña *
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="Mínimo 8 caracteres"
                                   required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Confirmar Contraseña *
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="Repita la contraseña"
                                   required>
                        </div>
                    </div>

                    <!-- Rol y Refugio -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rol -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rol del Usuario *
                            </label>
                            <select id="role" 
                                    name="role" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                    required>
                                <option value="">Seleccionar rol</option>
                                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="caretaker" {{ old('role') === 'caretaker' ? 'selected' : '' }}>Cuidador</option>
                                <option value="donor" {{ old('role') === 'donor' ? 'selected' : '' }}>Donador</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Refugio (Solo para cuidadores) -->
                        <div id="shelter-field" style="display: none;">
                            <label for="shelter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Refugio Asignado
                            </label>
                            <select id="shelter_id" 
                                    name="shelter_id" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200">
                                <option value="">Seleccionar refugio</option>
                                @foreach($shelters as $shelter)
                                    <option value="{{ $shelter->id }}" {{ old('shelter_id') == $shelter->id ? 'selected' : '' }}>
                                        {{ $shelter->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shelter_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Teléfono -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Teléfono
                            </label>
                            <input type="text" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                   placeholder="+52 123 456 7890">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-[#f56e5c] focus:ring-[#f56e5c] border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                Usuario activo
                            </label>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dirección
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                                  placeholder="Dirección completa del usuario">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200/30 dark:border-gray-700/30">
                        <a href="{{ route('admin.users') }}" 
                           class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 font-medium">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para mostrar/ocultar campo de refugio -->
    <script>
        document.getElementById('role').addEventListener('change', function() {
            const shelterField = document.getElementById('shelter-field');
            const shelterSelect = document.getElementById('shelter_id');
            
            if (this.value === 'caretaker') {
                shelterField.style.display = 'block';
                shelterSelect.required = true;
            } else {
                shelterField.style.display = 'none';
                shelterSelect.required = false;
                shelterSelect.value = '';
            }
        });

        // Ejecutar al cargar la página en caso de old values
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'caretaker') {
                document.getElementById('shelter-field').style.display = 'block';
                document.getElementById('shelter_id').required = true;
            }
        });
    </script>
</x-app-layout>
