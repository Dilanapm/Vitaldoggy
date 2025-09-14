@extends('layouts.base')

@section('title', 'Nueva Mascota')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.pets.index') }}" 
           class="mr-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Nueva Mascota</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Agrega una nueva mascota al sistema</p>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <form action="{{ route('admin.pets.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <!-- Información básica -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Básica</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Especie -->
                    <div>
                        <label for="species" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Especie <span class="text-red-500">*</span>
                        </label>
                        <select name="species" id="species" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Selecciona una especie</option>
                            <option value="dog" {{ old('species') === 'dog' ? 'selected' : '' }}>Perro</option>
                            <option value="cat" {{ old('species') === 'cat' ? 'selected' : '' }}>Gato</option>
                            <option value="other" {{ old('species') === 'other' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('species')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Raza -->
                    <div>
                        <label for="breed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Raza</label>
                        <input type="text" name="breed" id="breed" value="{{ old('breed') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('breed')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Edad -->
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Edad (años)</label>
                        <input type="number" name="age" id="age" value="{{ old('age') }}" min="0" max="50"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('age')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Género -->
                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Género <span class="text-red-500">*</span>
                        </label>
                        <select name="gender" id="gender" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Selecciona un género</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Macho</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Hembra</option>
                        </select>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tamaño -->
                    <div>
                        <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tamaño <span class="text-red-500">*</span>
                        </label>
                        <select name="size" id="size" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Selecciona un tamaño</option>
                            <option value="small" {{ old('size') === 'small' ? 'selected' : '' }}>Pequeño</option>
                            <option value="medium" {{ old('size') === 'medium' ? 'selected' : '' }}>Mediano</option>
                            <option value="large" {{ old('size') === 'large' ? 'selected' : '' }}>Grande</option>
                        </select>
                        @error('size')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Peso -->
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Peso (kg)</label>
                        <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="0" max="200" step="0.1"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('weight')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color</label>
                        <input type="text" name="color" id="color" value="{{ old('color') }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        @error('color')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Ubicación y cuidado -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ubicación y Cuidado</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Refugio -->
                    <div>
                        <label for="shelter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Refugio <span class="text-red-500">*</span>
                        </label>
                        <select name="shelter_id" id="shelter_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Selecciona un refugio</option>
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

                    <!-- Cuidador -->
                    <div>
                        <label for="caretaker_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cuidador</label>
                        <select name="caretaker_id" id="caretaker_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Sin cuidador asignado</option>
                            @foreach($caretakers as $caretaker)
                                <option value="{{ $caretaker->id }}" 
                                        data-shelter="{{ $caretaker->shelter_id }}"
                                        {{ old('caretaker_id') == $caretaker->id ? 'selected' : '' }}>
                                    {{ $caretaker->name }} ({{ $caretaker->shelter->name ?? 'Sin refugio' }})
                                </option>
                            @endforeach
                        </select>
                        @error('caretaker_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado de adopción -->
                    <div>
                        <label for="adoption_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Estado de Adopción <span class="text-red-500">*</span>
                        </label>
                        <select name="adoption_status" id="adoption_status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Selecciona un estado</option>
                            <option value="available" {{ old('adoption_status') === 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="pending" {{ old('adoption_status') === 'pending' ? 'selected' : '' }}>En proceso</option>
                            <option value="adopted" {{ old('adoption_status') === 'adopted' ? 'selected' : '' }}>Adoptado</option>
                            <option value="inactive" {{ old('adoption_status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('adoption_status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Estado de salud -->
            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Estado de Salud</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Esterilizado -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_sterilized" id="is_sterilized" value="1" 
                               {{ old('is_sterilized') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                        <label for="is_sterilized" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Esterilizado/a
                        </label>
                    </div>

                    <!-- Vacunado -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_vaccinated" id="is_vaccinated" value="1" 
                               {{ old('is_vaccinated') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                        <label for="is_vaccinated" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Vacunado/a
                        </label>
                    </div>

                    <!-- Desparasitado -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_dewormed" id="is_dewormed" value="1" 
                               {{ old('is_dewormed') ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                        <label for="is_dewormed" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Desparasitado/a
                        </label>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Información Adicional</h3>
                
                <div class="space-y-6">
                    <!-- Descripción -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descripción</label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                  placeholder="Describe las características y personalidad de la mascota...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Información médica -->
                    <div>
                        <label for="medical_info" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información Médica</label>
                        <textarea name="medical_info" id="medical_info" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                  placeholder="Información sobre tratamientos, condiciones médicas, etc...">{{ old('medical_info') }}</textarea>
                        @error('medical_info')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas de comportamiento -->
                    <div>
                        <label for="behavior_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Notas de Comportamiento</label>
                        <textarea name="behavior_notes" id="behavior_notes" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                  placeholder="Comportamiento con otros animales, personas, niños, etc...">{{ old('behavior_notes') }}</textarea>
                        @error('behavior_notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.pets.index') }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition duration-200 shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Crear Mascota
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const shelterSelect = document.getElementById('shelter_id');
    const caretakerSelect = document.getElementById('caretaker_id');
    
    // Filtrar cuidadores por refugio seleccionado
    shelterSelect.addEventListener('change', function() {
        const selectedShelter = this.value;
        const caretakerOptions = caretakerSelect.querySelectorAll('option');
        
        caretakerOptions.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
                return;
            }
            
            const optionShelter = option.dataset.shelter;
            if (selectedShelter === '' || optionShelter === selectedShelter) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
        
        // Reset caretaker selection if current selection is not valid
        const currentCaretaker = caretakerSelect.value;
        if (currentCaretaker) {
            const currentOption = caretakerSelect.querySelector(`option[value="${currentCaretaker}"]`);
            if (currentOption && currentOption.style.display === 'none') {
                caretakerSelect.value = '';
            }
        }
    });
    
    // Trigger initial filter
    shelterSelect.dispatchEvent(new Event('change'));
});
</script>
@endsection