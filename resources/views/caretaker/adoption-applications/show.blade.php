<x-app-layout :pageTitle="'Detalle de Solicitud de Adopción'" :metaDescription="'Revisa los detalles de la solicitud de adopción.'">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent">
                    Solicitud de Adopción
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-1">
                    {{ $adoptionApplication->pet->name }} • {{ $adoptionApplication->user->name }}
                </p>
            </div>
            <a href="{{ route('caretaker.adoption-applications.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="relative min-h-screen transition-colors duration-300">
        <!-- Hero background -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629] via-[#f56e5c] via-70% to-[#6b1f11] dark:bg-gradient-to-r dark:from-primary/5 dark:to-secondary/5"></div>
        
        <!-- Overlay para mejor legibilidad -->
        <div class="absolute inset-0 -z-5 bg-white/80 dark:bg-gray-900/85"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            <!-- Estado de la Solicitud -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Estado Actual</h3>
                        @switch($adoptionApplication->status)
                            @case('pending')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200">
                                    <span class="w-3 h-3 bg-yellow-400 rounded-full mr-3 animate-pulse"></span>
                                    Pendiente de Revisión
                                </span>
                                @break
                            @case('under_review')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200">
                                    <span class="w-3 h-3 bg-blue-400 rounded-full mr-3"></span>
                                    En Proceso de Revisión
                                </span>
                                @break
                            @case('approved')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200">
                                    <span class="w-3 h-3 bg-green-400 rounded-full mr-3"></span>
                                    Solicitud Aprobada
                                </span>
                                @break
                            @case('rejected')
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200">
                                    <span class="w-3 h-3 bg-red-400 rounded-full mr-3"></span>
                                    Solicitud Rechazada
                                </span>
                                @break
                        @endswitch
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de solicitud</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $adoptionApplication->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Información del Adoptante -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#751629]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        Información del Adoptante
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $adoptionApplication->user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $adoptionApplication->user->email }}</p>
                        </div>
                        
                        @if($adoptionApplication->applicant_info)
                            @foreach($adoptionApplication->applicant_info as $key => $value)
                                @if($value)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                                        </label>
                                        <p class="text-lg text-gray-900 dark:text-gray-100">{{ $value }}</p>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Experiencia con mascotas</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">
                                {{ $adoptionApplication->has_experience ? 'Sí' : 'No' }}
                            </p>
                        </div>
                        
                        @if($adoptionApplication->living_situation)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Situación de vivienda</label>
                                <p class="text-lg text-gray-900 dark:text-gray-100">{{ $adoptionApplication->living_situation }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Información de la Mascota -->
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#f56e5c]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2Z"/>
                        </svg>
                        Información de la Mascota
                    </h3>
                    
                    <div class="space-y-4">
                        @if($adoptionApplication->pet->photo)
                            <div class="flex justify-center mb-4">
                                <img src="{{ asset('storage/' . $adoptionApplication->pet->photo) }}" 
                                     alt="{{ $adoptionApplication->pet->name }}"
                                     class="w-32 h-32 object-cover rounded-full border-4 border-[#751629]">
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ $adoptionApplication->pet->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo y Raza</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">
                                {{ ucfirst($adoptionApplication->pet->type) }} • {{ $adoptionApplication->pet->breed }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Edad</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">
                                {{ $adoptionApplication->pet->age }} {{ $adoptionApplication->pet->age == 1 ? 'año' : 'años' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tamaño</label>
                            <p class="text-lg text-gray-900 dark:text-gray-100">{{ ucfirst($adoptionApplication->pet->size) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Razón de Adopción -->
            @if($adoptionApplication->reason)
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-[#6b1f11]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Razón para la Adopción
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $adoptionApplication->reason }}</p>
                </div>
            @endif

            <!-- Notas de Resolución -->
            @if($adoptionApplication->resolution_notes)
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>
                        </svg>
                        Notas del Cuidador
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $adoptionApplication->resolution_notes }}</p>
                    @if($adoptionApplication->resolvedBy)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Por: {{ $adoptionApplication->resolvedBy->name }} • 
                            {{ $adoptionApplication->resolution_date ? $adoptionApplication->resolution_date->format('d/m/Y H:i') : '' }}
                        </p>
                    @endif
                </div>
            @endif

            <!-- Acciones -->
            @if(in_array($adoptionApplication->status, ['pending', 'under_review']))
                <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm rounded-2xl shadow-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Acciones</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Marcar en Revisión -->
                        @if($adoptionApplication->status === 'pending')
                            <form method="POST" action="{{ route('caretaker.adoption-applications.review', $adoptionApplication) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <label for="review_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Notas (opcional)
                                    </label>
                                    <textarea id="review_notes" 
                                              name="resolution_notes" 
                                              rows="3"
                                              placeholder="Agregar notas sobre la revisión..."
                                              class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                                <button type="submit"
                                        class="w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                    Marcar en Revisión
                                </button>
                            </form>
                        @endif

                        <!-- Aprobar -->
                        <form method="POST" action="{{ route('caretaker.adoption-applications.approve', $adoptionApplication) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label for="approve_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Notas (opcional)
                                </label>
                                <textarea id="approve_notes" 
                                          name="resolution_notes" 
                                          rows="3"
                                          placeholder="Agregar notas sobre la aprobación..."
                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-green-500 focus:ring-green-500"></textarea>
                            </div>
                            <button type="submit"
                                    onclick="return confirm('¿Estás seguro de aprobar esta solicitud? La mascota será marcada como adoptada.')"
                                    class="w-full bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-600 transition-colors font-medium">
                                ✓ Aprobar Solicitud
                            </button>
                        </form>

                        <!-- Rechazar -->
                        <form method="POST" action="{{ route('caretaker.adoption-applications.reject', $adoptionApplication) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label for="reject_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Motivo del rechazo <span class="text-red-500">*</span>
                                </label>
                                <textarea id="reject_notes" 
                                          name="resolution_notes" 
                                          rows="3"
                                          required
                                          placeholder="Explica el motivo del rechazo..."
                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-red-500 focus:ring-red-500"></textarea>
                            </div>
                            <button type="submit"
                                    onclick="return confirm('¿Estás seguro de rechazar esta solicitud?')"
                                    class="w-full bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition-colors font-medium">
                                ✗ Rechazar Solicitud
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>