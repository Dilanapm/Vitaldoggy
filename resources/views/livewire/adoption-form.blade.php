<div class="max-w-4xl mx-auto p-6">
    @if($submitted)
        <!-- Mensaje de éxito -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/40 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-green-800 dark:text-green-200 mb-2">¡Solicitud Enviada!</h3>
            <p class="text-green-700 dark:text-green-300 mb-4">
                Tu solicitud para adoptar a <strong>{{ $pet->name }}</strong> ha sido enviada exitosamente.
            </p>
            <p class="text-green-600 dark:text-green-400 text-sm">
                El refugio revisará tu solicitud y te contactará pronto. ¡Gracias por querer darle un hogar a una mascota!
            </p>
            <div class="mt-6">
                <a href="{{ route('pets.index') }}" class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition duration-200">
                    Ver más mascotas
                </a>
            </div>
        </div>
    @else
        <!-- Información de la mascota -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center space-x-4">
                @if($pet->photos->count() > 0)
                    <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" 
                         alt="{{ $pet->name }}" 
                         class="w-16 h-16 rounded-full object-cover">
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-dark dark:text-white">Adoptar a {{ $pet->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300">{{ $pet->breed }} • {{ $pet->age }} {{ $pet->age == 1 ? 'año' : 'años' }}</p>
                </div>
            </div>
        </div>

        <!-- Indicador de progreso -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @for($i = 1; $i <= $maxSteps; $i++)
                    <div class="flex items-center {{ $i < $maxSteps ? 'flex-1' : '' }}">
                        <div class="relative">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                                {{ $step >= $i ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400' }}">
                                {{ $i }}
                            </div>
                            @if($i == 1)
                                <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    Información básica
                                </span>
                            @elseif($i == 2)
                                <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    Datos personales
                                </span>
                            @else
                                <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    Documentos
                                </span>
                            @endif
                        </div>
                        @if($i < $maxSteps)
                            <div class="flex-1 h-0.5 mx-4 {{ $step > $i ? 'bg-primary' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <!-- Formulario -->
        <form wire:submit="submit" class="space-y-6">
            <!-- Paso 1: Información básica -->
            @if($step == 1)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
                    <h3 class="text-xl font-semibold text-dark dark:text-white mb-4">¿Por qué quieres adoptar esta mascota?</h3>
                    
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cuéntanos tu motivación *
                        </label>
                        <textarea wire:model.live="reason" 
                                  id="reason"
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                                  placeholder="Explica por qué quieres adoptar a {{ $pet->name }}, qué puedes ofrecerle, etc. (Mínimo 50 caracteres)"></textarea>
                        @error('reason') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        <div class="mt-1 flex justify-between items-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="{{ strlen($reason) < 50 ? 'text-red-500' : (strlen($reason) > 1000 ? 'text-red-500' : 'text-green-600') }}">
                                    {{ strlen($reason) }}
                                </span>
                                /1000 caracteres
                                @if(strlen($reason) < 50)
                                    <span class="text-red-500 text-xs">(Mínimo 50 caracteres)</span>
                                @elseif(strlen($reason) > 1000)
                                    <span class="text-red-500 text-xs">(Máximo 1000 caracteres)</span>
                                @endif
                            </p>
                            @if(strlen($reason) >= 50 && strlen($reason) <= 1000)
                                <span class="text-xs text-green-600 dark:text-green-400">✓ Suficientes caracteres</span>
                            @elseif(strlen($reason) > 1000)
                                <span class="text-xs text-red-600 dark:text-red-400">✗ Demasiados caracteres</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="living_situation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Describe tu situación de vivienda *
                        </label>
                        <textarea wire:model.live="living_situation" 
                                  id="living_situation"
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                                  placeholder="Casa/apartamento, jardín, espacio disponible, etc."></textarea>
                        @error('living_situation') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        <div class="mt-1 flex justify-between items-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <span class="{{ strlen($living_situation) < 30 ? 'text-red-500' : (strlen($living_situation) > 500 ? 'text-red-500' : 'text-green-600') }}">
                                    {{ strlen($living_situation) }}
                                </span>
                                /500 caracteres
                                @if(strlen($living_situation) < 30)
                                    <span class="text-red-500 text-xs">(Mínimo 30 caracteres)</span>
                                @elseif(strlen($living_situation) > 500)
                                    <span class="text-red-500 text-xs">(Máximo 500 caracteres)</span>
                                @endif
                            </p>
                            @if(strlen($living_situation) >= 30 && strlen($living_situation) <= 500)
                                <span class="text-xs text-green-600 dark:text-green-400">✓ Suficientes caracteres</span>
                            @elseif(strlen($living_situation) > 500)
                                <span class="text-xs text-red-600 dark:text-red-400">✗ Demasiados caracteres</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" 
                                   wire:model="has_experience" 
                                   class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                Tengo experiencia previa cuidando mascotas
                            </span>
                        </label>
                    </div>
                </div>
            @endif

            <!-- Paso 2: Datos personales -->
            @if($step == 2)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
                    <h3 class="text-xl font-semibold text-dark dark:text-white mb-4">Información personal</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Teléfono *
                            </label>
                            <input type="tel" 
                                   wire:model.live.debounce.300ms="applicant_info.phone" 
                                   id="phone"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                            @error('applicant_info.phone') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label for="occupation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ocupación *
                            </label>
                            <input type="text" 
                                   wire:model.live.debounce.300ms="applicant_info.occupation" 
                                   id="occupation"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                            @error('applicant_info.occupation') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dirección completa *
                        </label>
                        <input type="text" 
                               wire:model.live.debounce.300ms="applicant_info.address" 
                               id="address"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        @error('applicant_info.address') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                    </div>

                    <div>
                        <label for="family_members" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Miembros de la familia *
                        </label>
                        <textarea wire:model.live="applicant_info.family_members" 
                                  id="family_members"
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                                  placeholder="Describe quién vive contigo, edades, etc."></textarea>
                        @error('applicant_info.family_members') 
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <span class="{{ strlen($applicant_info['family_members'] ?? '') > 500 ? 'text-red-500' : 'text-gray-600' }}">
                                {{ strlen($applicant_info['family_members'] ?? '') }}
                            </span>
                            /500 caracteres
                            @if(strlen($applicant_info['family_members'] ?? '') > 500)
                                <span class="text-red-500 text-xs">(Máximo 500 caracteres)</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label for="other_pets" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Otras mascotas (opcional)
                        </label>
                        <textarea wire:model="applicant_info.other_pets" 
                                  id="other_pets"
                                  rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                                  placeholder="¿Tienes otras mascotas? Descríbelas."></textarea>
                    </div>

                    <div>
                        <label for="references" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Referencias (opcional)
                        </label>
                        <textarea wire:model="applicant_info.references" 
                                  id="references"
                                  rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white"
                                  placeholder="Veterinario, amigos, familiares que puedan dar referencias."></textarea>
                    </div>
                </div>
            @endif

            <!-- Paso 3: Documentos -->
            @if($step == 3)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
                    <h3 class="text-xl font-semibold text-dark dark:text-white mb-4">Documentos requeridos</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="identification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Identificación oficial * 
                            </label>
                            <input type="file" 
                                   wire:model="identification" 
                                   id="identification"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                            @error('identification') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">INE, pasaporte, cédula profesional (JPG, PNG, PDF - Máx. 2MB)</p>
                            
                            @if($identification)
                                <div class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded text-sm text-green-700 dark:text-green-300">
                                    ✓ Archivo seleccionado: {{ $identification->getClientOriginalName() }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="proof_of_residence" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Comprobante de domicilio *
                            </label>
                            <input type="file" 
                                   wire:model="proof_of_residence" 
                                   id="proof_of_residence"
                                   accept=".jpg,.jpeg,.png,.pdf"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                            @error('proof_of_residence') 
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> 
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Recibo de luz, agua, teléfono (JPG, PNG, PDF - Máx. 2MB)</p>
                            
                            @if($proof_of_residence)
                                <div class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded text-sm text-green-700 dark:text-green-300">
                                    ✓ Archivo seleccionado: {{ $proof_of_residence->getClientOriginalName() }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-medium text-blue-800 dark:text-blue-200 mb-2">Información importante:</h4>
                        <ul class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
                            <li>• El proceso de adopción puede tomar entre 3-7 días</li>
                            <li>• Un cuidador del refugio se pondrá en contacto contigo</li>
                            <li>• Puede que se requiera una visita domiciliaria</li>
                            <li>• Todos los documentos son confidenciales y seguros</li>
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Botones de navegación -->
            <div class="flex justify-between">
                @if($step > 1)
                    <button type="button" 
                            wire:click="previousStep"
                            class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition duration-200">
                        Anterior
                    </button>
                @else
                    <div></div>
                @endif

                @if($step < $maxSteps)
                    <button type="button" 
                            wire:click="nextStep"
                            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition duration-200">
                        Siguiente
                    </button>
                @else
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition duration-200 disabled:opacity-50">
                        <span wire:loading.remove>Enviar solicitud</span>
                        <span wire:loading>Enviando...</span>
                    </button>
                @endif
            </div>
        </form>
    @endif
</div>
