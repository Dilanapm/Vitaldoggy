@extends('layouts.base')

@section('title', 'Mascotas en Adopción')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-primary">Mascotas en Adopción</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($pets as $pet)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex flex-col">
                @if($pet->photos && $pet->photos->count())
                    <img src="{{ asset('storage/' . $pet->photos->first()->photo_path) }}" alt="Foto de {{ $pet->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">Sin foto</div>
                @endif
                <div class="p-4 flex-1 flex flex-col">
                    <h2 class="text-xl font-semibold text-dark dark:text-white mb-2">{{ $pet->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 mb-2">{{ $pet->breed ?? 'Raza desconocida' }}</p>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Edad: {{ $pet->age ?? 'N/D' }}</p>
                    <div class="mt-auto">
                        <a href="#" class="block w-full text-center px-4 py-2 rounded bg-primary text-white font-medium hover:bg-primary/90 transition duration-200">Solicitar adopción</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="col-span-4 text-center text-gray-500">No hay mascotas disponibles en este momento.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $pets->links() }}
    </div>
</div>
@endsection
