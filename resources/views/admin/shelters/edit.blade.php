@extends('layouts.app')

@section('title', 'Editar Refugio')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#751629] via-[#f56e5c] to-[#6b1f11] py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.shelters.index') }}" 
                   class="text-white/80 hover:text-white transition-colors duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-white">Editar Refugio</h1>
                    <p class="text-white/80 mt-2">Modificar información del refugio {{ $shelter->name }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-white/20">
                <h2 class="text-xl font-semibold text-white">Información del Refugio</h2>
            </div>

            <form action="{{ route('admin.shelters.update', $shelter) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-white mb-2">
                            Nombre del Refugio <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name', $shelter->name) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="Ej: Refugio Esperanza Animal">
                        @error('name')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email', $shelter->email) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="refugio@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-white mb-2">
                            Teléfono <span class="text-red-400">*</span>
                        </label>
                        <input type="tel" name="phone" id="phone" required
                               value="{{ old('phone', $shelter->phone) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="(123) 456-7890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-white mb-2">
                            Dirección <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="address" id="address" required
                               value="{{ old('address', $shelter->address) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="Calle 123, Colonia Centro">
                        @error('address')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-white mb-2">
                            Ciudad <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="city" id="city" required
                               value="{{ old('city', $shelter->city) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="Ciudad de México">
                        @error('city')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-white mb-2">
                            Capacidad (número de mascotas)
                        </label>
                        <input type="number" name="capacity" id="capacity" min="1"
                               value="{{ old('capacity', $shelter->capacity) }}"
                               class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                               placeholder="50">
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-white mb-2">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200">
                            <option value="active" {{ old('status', $shelter->status) === 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status', $shelter->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-white mb-2">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200 resize-none"
                                  placeholder="Describe el refugio, su misión y servicios...">{{ old('description', $shelter->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image -->
                    @if($shelter->hasImage())
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-white mb-2">
                            Imagen Actual
                        </label>
                        <div class="mb-4">
                            <img src="{{ $shelter->image_url }}" alt="{{ $shelter->name }}" 
                                 class="w-32 h-32 object-cover rounded-xl border border-white/20">
                        </div>
                    </div>
                    @endif

                    <!-- New Image -->
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-white mb-2">
                            {{ $shelter->hasImage() ? 'Cambiar Imagen' : 'Agregar Imagen' }}
                        </label>
                        <div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-white/20 border-dashed rounded-xl hover:border-white/30 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-white/60" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-white/70">
                                    <label for="image" class="relative cursor-pointer bg-white/10 rounded-md font-medium text-white hover:text-white/80 hover:bg-white/20 focus-within:outline-none focus-within:ring-2 focus-within:ring-white/30 focus-within:ring-offset-2 px-3 py-1 transition-all duration-200">
                                        <span>Selecciona una imagen</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-white/60">PNG, JPG, JPEG hasta 2MB</p>
                                @if($shelter->hasImage())
                                <p class="text-xs text-white/60">Dejar vacío para mantener la imagen actual</p>
                                @endif
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Statistics Section -->
                    <div class="md:col-span-2 border-t border-white/20 pt-6">
                        <h3 class="text-lg font-medium text-white mb-4">Estadísticas del Refugio</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="bg-white/5 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white">{{ $shelter->pets_count ?? 0 }}</div>
                                <div class="text-white/70 text-sm">Mascotas</div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white">{{ $shelter->caretakers_count ?? 0 }}</div>
                                <div class="text-white/70 text-sm">Cuidadores</div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 text-center">
                                <div class="text-2xl font-bold text-white">
                                    {{ $shelter->created_at->diffForHumans() }}
                                </div>
                                <div class="text-white/70 text-sm">Registrado</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-white/20">
                    <a href="{{ route('admin.shelters.index') }}" 
                       class="px-6 py-3 bg-white/10 text-white rounded-xl hover:bg-white/20 transition-all duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-white text-[#751629] rounded-xl hover:bg-white/90 transition-all duration-200 font-semibold shadow-lg">
                        <i class="fas fa-save mr-2"></i>Actualizar Refugio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de imagen
    const imageInput = document.getElementById('image');
    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Aquí podrías mostrar un preview de la nueva imagen
                console.log('Nueva imagen seleccionada:', file.name);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
