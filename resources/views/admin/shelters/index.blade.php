@extends('layouts.app')

@section('title', 'Administrar Refugios')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#751629] via-[#f56e5c] to-[#6b1f11] py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">Administrar Refugios</h1>
                    <p class="text-white/80 mt-2">Gestiona todos los refugios de la plataforma</p>
                </div>
                <a href="{{ route('admin.shelters.create') }}" 
                   class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-xl hover:bg-white/30 transition-all duration-300 font-semibold shadow-lg">
                    <i class="fas fa-plus mr-2"></i>Crear Refugio
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="text-white/80 text-sm font-medium uppercase tracking-wide mb-2">Total Refugios</div>
                <div class="text-3xl font-bold text-white">{{ $shelters->count() }}</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="text-white/80 text-sm font-medium uppercase tracking-wide mb-2">Refugios Activos</div>
                <div class="text-3xl font-bold text-white">{{ $shelters->where('status', 'active')->count() }}</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-center">
                <div class="text-white/80 text-sm font-medium uppercase tracking-wide mb-2">Refugios Inactivos</div>
                <div class="text-3xl font-bold text-white">{{ $shelters->where('status', 'inactive')->count() }}</div>
            </div>
        </div>

        <!-- Shelters Table -->
        <div class="bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl">
            <div class="p-6 border-b border-white/20">
                <h2 class="text-xl font-semibold text-white">Lista de Refugios</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-white/5">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Imagen</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Información</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Contacto</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Estadísticas</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-white/80 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($shelters as $shelter)
                        <tr class="hover:bg-white/5 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-white/20">
                                    @if($shelter->hasImage())
                                        <img src="{{ $shelter->image_url }}" alt="{{ $shelter->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-white/60">
                                            <i class="fas fa-home text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-lg font-semibold text-white">{{ $shelter->name }}</div>
                                    <div class="text-white/70 text-sm">{{ $shelter->address }}</div>
                                    <div class="text-white/60 text-sm">{{ $shelter->city }}</div>
                                    <div class="text-white/80 text-sm mt-1">
                                        <i class="fas fa-users mr-1"></i>Capacidad: {{ $shelter->capacity ?? 'No especificada' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="text-white/80 text-sm">
                                        <i class="fas fa-envelope mr-2"></i>{{ $shelter->email ?? 'No especificado' }}
                                    </div>
                                    <div class="text-white/80 text-sm">
                                        <i class="fas fa-phone mr-2"></i>{{ $shelter->phone ?? 'No especificado' }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-2">
                                    <div class="text-white/80 text-sm">
                                        <i class="fas fa-dog mr-2"></i>{{ $shelter->pets_count ?? 0 }} mascotas
                                    </div>
                                    <div class="text-white/80 text-sm">
                                        <i class="fas fa-user-tie mr-2"></i>{{ $shelter->caretakers_count ?? 0 }} cuidadores
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.shelters.toggle-status', $shelter) }}" method="POST" 
                                      onsubmit="return confirm('¿Estás seguro de cambiar el estado de este refugio?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium transition-colors duration-200 
                                                   {{ $shelter->status === 'active' 
                                                      ? 'bg-green-500/20 text-green-200 hover:bg-green-500/30' 
                                                      : 'bg-red-500/20 text-red-200 hover:bg-red-500/30' }}">
                                        @if($shelter->status === 'active')
                                            <i class="fas fa-check mr-1"></i>Activo
                                        @else
                                            <i class="fas fa-times mr-1"></i>Inactivo
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.shelters.show', $shelter) }}" 
                                       class="text-blue-300 hover:text-blue-200 transition-colors duration-200" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.shelters.edit', $shelter) }}" 
                                       class="text-yellow-300 hover:text-yellow-200 transition-colors duration-200" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.shelters.destroy', $shelter) }}" method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este refugio? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-300 hover:text-red-200 transition-colors duration-200" 
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-white/60">
                                    <i class="fas fa-home text-4xl mb-4"></i>
                                    <div class="text-lg font-medium mb-2">No hay refugios registrados</div>
                                    <div class="text-sm">Comienza creando el primer refugio</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="mt-8 text-center">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center text-white/80 hover:text-white transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al Panel de Administración
            </a>
        </div>
    </div>
</div>
@endsection
