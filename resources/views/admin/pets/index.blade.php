@extends('layouts.base')

@section('title', 'Gestión de Mascotas')
@section('description', 'Administra todas las mascotas del sistema desde el panel de administración.')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header con información del admin -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Panel de Administración - Mascotas</h1>
                <p class="mt-2 opacity-90">Vista completa de administrador con controles avanzados</p>
            </div>
            <a href="{{ route('admin.pets.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg transition duration-200 shadow-lg border border-white/20">
                <i class="fas fa-plus mr-2"></i>
                Nueva Mascota
            </a>
        </div>
    </div>

    <!-- Componente Livewire existente -->
    <livewire:pet-listing />
</div>
@endsection