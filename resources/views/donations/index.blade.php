@extends('layouts.base')

@section('title', 'Donaciones - VitalDoggy')
@section('description', 'Ayuda a salvar vidas con tu donación. Cada aporte cuenta para rescatar, cuidar y encontrar hogares para mascotas abandonadas.')

@section('content')
<div class="min-h-screen dark:bg-gray-900/75">
    <!-- Hero Section -->
    <div class="py-16 lg:py-24 container mx-auto px-6">
        <div class="text-center mb-16">
            <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                    Dona y Salva Vidas
                </span>
            </h1>
            <p class="text-lg lg:text-xl text-gray-800 dark:text-gray-300 max-w-4xl mx-auto">
                Tu donación hace la diferencia en la vida de mascotas abandonadas. Cada peso ayuda a rescatar, alimentar, 
                cuidar médicamente y encontrar hogares amorosos para perros y gatos en situación de vulnerabilidad.
            </p>
        </div>

        <!-- Estadísticas de impacto -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="text-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="text-4xl font-bold text-green-600 dark:text-green-400 mb-2">{{ $totalDonations > 0 ? '$' . number_format($totalDonations) : '∞' }}</div>
                <div class="text-gray-600 dark:text-gray-400">Potencial de impacto</div>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Tu donación suma al cuidado de mascotas</p>
            </div>
            <div class="text-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ $shelters->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Refugios aliados</div>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Refugios que puedes apoyar directamente</p>
            </div>
            <div class="text-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                <div class="text-4xl font-bold text-yellow-600 dark:text-yellow-400 mb-2">24/7</div>
                <div class="text-gray-600 dark:text-gray-400">Cuidado continuo</div>
                <p class="text-sm text-gray-500 dark:text-gray-500 mt-2">Atención permanente para las mascotas</p>
            </div>
        </div>
    </div>

    <!-- Formas de donar -->
    <div class="py-16 bg-gray-50/80 dark:bg-gray-800/50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    ¿Cómo puedes ayudar?
                </h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Hay muchas formas de contribuir. Desde donaciones monetarias hasta suministros específicos, 
                    cada aporte tiene un impacto directo en el bienestar de los animales.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Donación monetaria -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-donate text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Donación Monetaria</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Contribuye con dinero para gastos médicos, alimentación y cuidados generales.</p>
                    <a href="{{ route('donations.create') }}?type=money" 
                       class="inline-block px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                        Donar ahora
                    </a>
                </div>

                <!-- Alimento -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-2xl text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Alimento</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Dona comida para perros y gatos, snacks nutritivos y alimentos especiales.</p>
                    <a href="{{ route('donations.create') }}?type=food" 
                       class="inline-block px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition duration-200">
                        Contribuir
                    </a>
                </div>

                <!-- Suministros médicos -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heartbeat text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Medicina</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Ayuda con medicamentos, vacunas y tratamientos médicos especializados.</p>
                    <a href="{{ route('donations.create') }}?type=medicine" 
                       class="inline-block px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200">
                        Ayudar
                    </a>
                </div>

                <!-- Suministros generales -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 text-center hover:shadow-xl transition duration-300">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-box text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Suministros</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Mantas, juguetes, collares, correas, camas y artículos de cuidado.</p>
                    <a href="{{ route('donations.create') }}?type=supplies" 
                       class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        Donar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Refugios para donar -->
    @if($shelters->count() > 0)
    <div class="py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                    Elige un refugio para apoyar
                </h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                    Puedes dirigir tu donación directamente a un refugio específico o hacer una donación general 
                    que se distribuirá según las necesidades más urgentes.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($shelters->take(6) as $shelter)
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden hover:shadow-xl transition duration-300">
                    @if($shelter->hasImage())
                        <img src="{{ $shelter->image_url }}" 
                             alt="{{ $shelter->name }}"
                             class="w-full h-40 object-cover">
                    @else
                        <div class="w-full h-40 bg-gradient-to-r from-[#751629]/20 to-[#f56e5c]/20 flex items-center justify-center">
                            <i class="fas fa-home text-4xl text-gray-400"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $shelter->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $shelter->city }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-500 mb-4">
                            Capacidad: {{ $shelter->capacity }} mascotas
                        </p>
                        <a href="{{ route('donations.create', $shelter) }}" 
                           class="block w-full text-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition duration-200">
                            Donar a este refugio
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('donations.create') }}" 
                   class="inline-block px-8 py-4 bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium rounded-lg hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg text-lg">
                    <i class="fas fa-heart mr-2"></i>Hacer donación general
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Transparencia e impacto -->
    <div class="py-16 bg-gray-50/80 dark:bg-gray-800/50">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Tu donación marca la diferencia
                    </h2>
                    <p class="text-lg text-gray-700 dark:text-gray-300">
                        Somos transparentes sobre cómo se utilizan las donaciones. Cada peso cuenta y cada mascota salvada importa.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-chart-pie text-blue-600 mr-2"></i>
                            ¿En qué se invierte?
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Alimentación</span>
                                <span class="font-semibold text-gray-900 dark:text-white">40%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Atención médica</span>
                                <span class="font-semibold text-gray-900 dark:text-white">35%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Instalaciones</span>
                                <span class="font-semibold text-gray-900 dark:text-white">15%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-700 dark:text-gray-300">Operación</span>
                                <span class="font-semibold text-gray-900 dark:text-white">10%</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-paw text-green-600 mr-2"></i>
                            Impacto de tu donación
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 font-bold mr-2">$10</span>
                                <span class="text-gray-700 dark:text-gray-300">Alimenta a una mascota por 3 días</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 font-bold mr-2">$50</span>
                                <span class="text-gray-700 dark:text-gray-300">Cubre una consulta veterinaria básica</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 font-bold mr-2">$100</span>
                                <span class="text-gray-700 dark:text-gray-300">Financia una cirugía de esterilización</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-green-600 dark:text-green-400 font-bold mr-2">$200</span>
                                <span class="text-gray-700 dark:text-gray-300">Rescata y rehabilita una mascota</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-6 rounded-lg">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                            <div class="text-left">
                                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-300">Compromiso de transparencia</h4>
                                <p class="text-blue-800 dark:text-blue-400">
                                    Todas las donaciones son gestionadas de manera transparente. Recibirás actualizaciones sobre el impacto de tu contribución.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Final -->
    <div class="py-16 bg-gradient-to-r from-[#751629] to-[#f56e5c]">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Cada donación salva una vida
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-3xl mx-auto">
                No importa el tamaño de tu donación, lo que importa es tu intención de ayudar. 
                Juntos podemos hacer una diferencia real en la vida de mascotas que necesitan amor y cuidado.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('donations.create') }}" 
                   class="px-8 py-4 bg-white text-[#751629] font-bold rounded-lg hover:bg-gray-100 transition duration-200 text-lg">
                    <i class="fas fa-donate mr-2"></i>Donar ahora
                </a>
                <a href="{{ route('shelters.index') }}" 
                   class="px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-[#751629] transition duration-200 text-lg">
                    <i class="fas fa-home mr-2"></i>Conocer refugios
                </a>
            </div>
        </div>
    </div>
</div>
@endsection