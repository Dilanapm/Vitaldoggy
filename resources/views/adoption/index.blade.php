@extends('layouts.base')

@section('title', 'Mis Solicitudes de Adopción')
@section('description', 'Gestiona tus solicitudes de adopción pendientes y revisa el estado de las mismas.')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="container mx-auto px-6">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Mis Solicitudes de Adopción
                </h1>
                <p class="text-gray-600 dark:text-gray-300">
                    Aquí puedes ver todas las solicitudes de adopción que has enviado y su estado actual.
                </p>
            </div>

            @if($applications->count() > 0)
                <div class="grid gap-6">
                    @foreach($applications as $application)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div class="md:flex">
                                <!-- Imagen de la mascota -->
                                <div class="md:w-48 h-48 md:h-auto">
                                    @if($application->pet->image_path)
                                        <img src="{{ asset('storage/' . $application->pet->image_path) }}" 
                                             alt="{{ $application->pet->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Información de la solicitud -->
                                <div class="p-6 flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                                {{ $application->pet->name }}
                                            </h3>
                                            <p class="text-gray-600 dark:text-gray-300 mb-2">
                                                {{ $application->pet->breed }} • {{ $application->pet->age }} años
                                            </p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Solicitud enviada: {{ $application->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>

                                        <!-- Estado -->
                                        <div class="flex flex-col items-end">
                                            @switch($application->status)
                                                @case('pending')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                        </svg>
                                                        Pendiente
                                                    </span>
                                                    @break
                                                @case('approved')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                        Aprobada
                                                    </span>
                                                    @break
                                                @case('rejected')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                        Rechazada
                                                    </span>
                                                    @break
                                                @case('under_review')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        En revisión
                                                    </span>
                                                    @break
                                            @endswitch

                                            @if($application->priority_score)
                                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                    Puntuación: {{ $application->priority_score }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Información adicional -->
                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-medium">Motivación:</span>
                                                {{ Str::limit($application->motivation, 100) }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                <span class="font-medium">Experiencia:</span>
                                                {{ $application->experience ? 'Sí' : 'No' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Documentos -->
                                    @if($application->documents->count() > 0)
                                        <div class="border-t dark:border-gray-700 pt-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                                Documentos adjuntos:
                                            </p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($application->documents as $document)
                                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $document->document_type }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Notas del administrador -->
                                    @if($application->admin_notes)
                                        <div class="border-t dark:border-gray-700 pt-4 mt-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                                Notas del administrador:
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $application->admin_notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            @else
                <!-- Estado vacío -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">
                        No has enviado solicitudes de adopción
                    </h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">
                        Cuando envíes una solicitud de adopción aparecerá aquí.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('pets.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 transition duration-200">
                            Ver mascotas disponibles
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
