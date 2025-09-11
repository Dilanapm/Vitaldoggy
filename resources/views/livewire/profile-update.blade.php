<div>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Información del Perfil
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Actualiza la información de tu cuenta y dirección de correo electrónico.
            </p>
        </header>

        <form wire:submit="updateProfile" class="mt-6 space-y-6">
            <!-- Foto de perfil -->
            <div class="space-y-4">
                <x-input-label for="profile_photo" value="Foto de Perfil" class="text-lg font-semibold" />
                
                <div class="flex items-center space-x-6">
                    <!-- Preview de la foto actual o icono por defecto -->
                    <div class="relative">
                        @if($current_photo_path)
                            <img src="{{ asset('storage/' . $current_photo_path) }}" alt="Foto de perfil" 
                                 class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white dark:border-gray-700">
                        @elseif($profile_photo)
                            <img src="{{ $profile_photo->temporaryUrl() }}" alt="Preview" 
                                 class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white dark:border-gray-700">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 dark:from-[#751629]/30 dark:to-[#f56e5c]/30 flex items-center justify-center shadow-lg border-4 border-white dark:border-gray-700">
                                <svg class="w-12 h-12 text-[#751629] dark:text-[#f56e5c]" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <input type="file" wire:model="profile_photo" accept="image/*" 
                               class="block w-full text-sm text-gray-500 dark:text-gray-300
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-xl file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-gradient-to-r file:from-[#751629] file:to-[#f56e5c] file:text-white
                                      hover:file:bg-gradient-to-r hover:file:from-[#8b1538] hover:file:to-[#f77a6b]
                                      file:transition-all file:duration-300 file:cursor-pointer">
                        
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF hasta 2MB</p>
                        
                        @if($current_photo_path)
                            <button type="button" wire:click="deletePhoto" 
                                    wire:confirm="¿Estás seguro de eliminar tu foto de perfil?"
                                    class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium mt-2">
                                Eliminar foto
                            </button>
                        @endif
                        
                        <div wire:loading wire:target="profile_photo" class="text-xs text-blue-600 mt-2">
                            Subiendo imagen...
                        </div>
                    </div>
                </div>
                @error('profile_photo') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input-label for="name" value="Nombre" />
                <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                @error('name') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input-label for="username" value="Nombre de Usuario" />
                <x-text-input wire:model="username" id="username" name="username" type="text" class="mt-1 block w-full" required />
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Solo letras, números y guiones bajos. Debe ser único.</p>
                @error('username') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input-label for="email" value="Email" />
                <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required />
                @error('email') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input-label for="phone" value="Teléfono" />
                <x-text-input wire:model="phone" id="phone" name="phone" type="text" class="mt-1 block w-full" />
                @error('phone') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div>
                <x-input-label for="address" value="Dirección" />
                <x-text-input wire:model="address" id="address" name="address" type="text" class="mt-1 block w-full" />
                @error('address') <span class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button wire:loading.attr="disabled">
                    <span wire:loading.remove>Guardar</span>
                    <span wire:loading>Guardando...</span>
                </x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                       class="text-sm font-medium text-green-600 dark:text-green-400">
                        ✅ Perfil actualizado exitosamente
                    </p>
                @endif

                @if (session('status') === 'photo-deleted')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                       class="text-sm font-medium text-red-600 dark:text-red-400">
                        🗑️ Foto eliminada exitosamente
                    </p>
                @endif
            </div>
        </form>
    </section>
</div>
