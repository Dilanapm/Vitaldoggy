@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#751629] via-[#f56e5c] to-[#6b1f11] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.users') }}" 
                   class="text-white/80 hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">Editar Usuario</h1>
                    <p class="text-white/80 mt-2">Modificar información del usuario {{ $user->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-white/20">
                <h2 class="text-xl font-semibold text-white">Información del Usuario</h2>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-white mb-2">
                            Nombre Completo <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="Juan Pérez">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-white mb-2">
                            Nombre de Usuario <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="username" id="username" required
                               value="{{ old('username', $user->username) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="usuario123">
                        @error('username')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-white/60">Solo letras, números y guiones bajos.</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            Correo Electrónico <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="usuario@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-white mb-2">
                            Teléfono
                        </label>
                        <input type="tel" name="phone" id="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="(123) 456-7890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-white mb-2">
                            Dirección
                        </label>
                        <input type="text" name="address" id="address"
                               value="{{ old('address', $user->address) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="Calle 123, Colonia Centro">
                        @error('address')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shelter Assignment (solo para caretakers/volunteers) -->
                    <div>
                        <label for="shelter_id" class="block text-sm font-medium text-white mb-2">
                            Refugio Asignado
                        </label>
                        <select name="shelter_id" id="shelter_id"
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200">
                            <option value="">Sin asignar</option>
                            @foreach($shelters as $shelter)
                                <option value="{{ $shelter->id }}" 
                                        {{ old('shelter_id', $user->shelter_id) == $shelter->id ? 'selected' : '' }}>
                                    {{ $shelter->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('shelter_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-white mb-2">
                            Estado de la Cuenta <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200">
                            <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Roles (display only) -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-white mb-2">
                            Roles Actuales
                        </label>
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($user->roles) && count($user->roles) > 0)
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                               {{ $role === 'admin' ? 'bg-purple-500/20 text-purple-200' : 
                                                  ($role === 'Adoptante' ? 'bg-green-500/20 text-green-200' : 
                                                  ($role === 'Donador' ? 'bg-blue-500/20 text-blue-200' : 
                                                  ($role === 'Voluntario' ? 'bg-yellow-500/20 text-yellow-200' : 'bg-gray-500/20 text-gray-200'))) }}">
                                        {{ $role }}
                                    </span>
                                @endforeach
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-200">
                                    Sin roles asignados
                                </span>
                            @endif
                        </div>
                        <p class="text-white/60 text-sm mt-1">Los roles se asignan automáticamente basados en las acciones del usuario</p>
                    </div>

                    <!-- Password Change Section -->
                    <div class="md:col-span-2 border-t border-white/20 pt-6">
                        <h3 class="text-lg font-medium text-white mb-4">Cambiar Contraseña (opcional)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-white mb-2">
                                    Nueva Contraseña
                                </label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                                       placeholder="Dejar en blanco para mantener actual">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-white mb-2">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                                       placeholder="Confirmar nueva contraseña">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-white/20">
                    <a href="{{ route('admin.users') }}" 
                       class="px-6 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-white text-[#751629] rounded-xl hover:bg-white/90 transition-all duration-200 font-semibold shadow-lg">
                        <i class="fas fa-save mr-2"></i>Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
