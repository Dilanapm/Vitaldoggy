@extends('layouts.base')

@section('title', 'Crear Refugio')

@section('content')
<div class="relative min-h-screen transition-colors duration-300">
    <!-- Hero background -->
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
    
    <!-- Overlay para mejor legibilidad -->
    <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
    
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.shelters.index') }}" 
                   class="p-2 rounded-full bg-white/20 dark:bg-gray-700/50 backdrop-blur-sm hover:bg-white/30 dark:hover:bg-gray-600/50 transition-all duration-200">
                    <i class="fas fa-arrow-left text-xl text-gray-700 dark:text-gray-300"></i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold mb-2">
                        <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                            Crear Nuevo Refugio
                        </span>
                    </h1>
                    <p class="text-lg text-gray-700 dark:text-gray-300">Registra un nuevo refugio en la plataforma</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-[#751629]/10 to-[#f56e5c]/10 dark:from-[#751629]/20 dark:to-[#f56e5c]/20 border-b border-gray-200/30 dark:border-gray-700/30">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Información del Refugio</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-2">Complete todos los campos para registrar el nuevo refugio</p>
            </div>

            <form action="{{ route('admin.shelters.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre del Refugio <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required
                               value="{{ old('name') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="Ej: Refugio Esperanza Animal">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" required
                               value="{{ old('email') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="refugio@email.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Teléfono <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" name="phone" id="phone" required
                               value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="(123) 456-7890">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dirección <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="address" id="address" required
                               value="{{ old('address') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="Calle 123, Colonia Centro">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ciudad <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="city" id="city" required
                               value="{{ old('city') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="Ciudad de México">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Capacidad (número de mascotas)
                        </label>
                        <input type="number" name="capacity" id="capacity" min="1"
                               value="{{ old('capacity') }}"
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200"
                               placeholder="50">
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Activo</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Descripción
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-[#f56e5c] focus:border-transparent bg-white/50 dark:bg-gray-700/50 text-gray-900 dark:text-white transition-all duration-200 resize-none"
                                  placeholder="Describe el refugio, su misión y servicios...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="md:col-span-2">
                        <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagen del Refugio
                        </label>
                        
                        <!-- Preview Container (hidden by default) -->
                        <div id="image-preview-container" class="hidden mb-4">
                            <div class="relative inline-block">
                                <img id="image-preview" class="h-32 w-32 object-cover rounded-xl shadow-lg border-2 border-gray-200 dark:border-gray-600" src="" alt="Preview">
                                <button type="button" id="remove-image" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                <span id="selected-file-name"></span>
                            </p>
                        </div>

                        <!-- Upload Area -->
                        <div id="upload-area" class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-xl hover:border-[#f56e5c] dark:hover:border-[#f56e5c] transition-colors duration-200 bg-white/30 dark:bg-gray-700/30">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-500 dark:text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-[#f56e5c] hover:text-[#751629] focus-within:outline-none focus-within:ring-2 focus-within:ring-[#f56e5c] focus-within:ring-offset-2 px-3 py-1 transition-all duration-200">
                                        <span>Selecciona una imagen</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">o arrastra y suelta</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, JPEG hasta 2MB</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.shelters.index') }}" 
                       class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-xl hover:from-[#661520] hover:to-[#e55a4f] transition-all duration-200 font-semibold shadow-lg">
                        <i class="fas fa-save mr-2"></i>Crear Refugio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const uploadArea = document.getElementById('upload-area');
    const previewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const selectedFileName = document.getElementById('selected-file-name');
    const removeImageBtn = document.getElementById('remove-image');

    // Handle file selection
    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            handleFileSelection(file);
        }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.add('border-[#f56e5c]', 'bg-[#f56e5c]/5');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('border-[#f56e5c]', 'bg-[#f56e5c]/5');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        uploadArea.classList.remove('border-[#f56e5c]', 'bg-[#f56e5c]/5');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                imageInput.files = files;
                handleFileSelection(file);
            } else {
                showError('Por favor selecciona solo archivos de imagen.');
            }
        }
    });

    // Remove image button
    removeImageBtn.addEventListener('click', function() {
        resetImageSelection();
    });

    function handleFileSelection(file) {
        // Validate file size (2MB = 2048KB)
        if (file.size > 2048 * 1024) {
            showError('La imagen no puede ser mayor a 2MB.');
            resetImageSelection();
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showError('Solo se permiten archivos PNG, JPG y JPEG.');
            resetImageSelection();
            return;
        }

        // Create preview
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            selectedFileName.textContent = file.name;
            
            // Show preview and hide upload area
            previewContainer.classList.remove('hidden');
            uploadArea.classList.add('hidden');
            
            // Add success animation
            previewContainer.classList.add('animate-fadeIn');
            setTimeout(() => {
                previewContainer.classList.remove('animate-fadeIn');
            }, 300);
        };
        reader.readAsDataURL(file);
    }

    function resetImageSelection() {
        imageInput.value = '';
        imagePreview.src = '';
        selectedFileName.textContent = '';
        previewContainer.classList.add('hidden');
        uploadArea.classList.remove('hidden');
        
        // Remove any error messages
        const errorMessages = document.querySelectorAll('.image-error');
        errorMessages.forEach(msg => msg.remove());
    }

    function showError(message) {
        // Remove existing error messages
        const existingErrors = document.querySelectorAll('.image-error');
        existingErrors.forEach(error => error.remove());
        
        // Create new error message
        const errorElement = document.createElement('p');
        errorElement.className = 'mt-1 text-sm text-red-600 dark:text-red-400 image-error';
        errorElement.textContent = message;
        
        // Insert after upload area
        uploadArea.parentNode.insertBefore(errorElement, uploadArea.nextSibling);
        
        // Auto-remove error after 5 seconds
        setTimeout(() => {
            errorElement.remove();
        }, 5000);
    }
});
</script>

<!-- Add custom CSS for animations -->
<style>
.animate-fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Drag and drop visual feedback */
#upload-area.border-[#f56e5c] {
    border-color: #f56e5c !important;
    background-color: rgba(245, 110, 92, 0.05) !important;
}
</style>
@endsection
