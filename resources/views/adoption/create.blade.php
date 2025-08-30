@extends('layouts.base')

@section('title', 'Solicitar Adopción - ' . $pet->name)
@section('description', 'Solicita la adopción de ' . $pet->name . ' llenando nuestro formulario seguro.')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="container mx-auto px-6">
            <div class="mb-8">
                <a href="{{ route('pets.index') }}" 
                   class="inline-flex items-center text-primary hover:text-primary/80 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Volver a mascotas
                </a>
            </div>

            <!-- Componente Livewire -->
            <livewire:adoption-form :pet="$pet" />
        </div>
    </div>
@endsection
