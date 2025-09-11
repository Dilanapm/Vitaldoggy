@extends('layouts.base')

@section('title', 'Servicios - VitalDoggy')
@section('description', 'Conoce nuestros servicios: adopción de mascotas, donaciones y voluntariado. Únete a nuestra misión de salvar vidas.')

@section('content')
    <div class="dark:bg-gray-900/75">
        <!-- Hero Section -->
        <section class="relative py-2 lg:py-2 container mx-auto px-6">
        <div class="text-center mb-6">
            <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
                <span class="bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] bg-clip-text text-transparent dark:from-primary dark:via-accent dark:to-secondary">
                    Nuestros Servicios
                </span>
            </h1>
            <p class="text-lg text-gray-700 dark:text-gray-300 max-w-3xl mx-auto">
                En VitalDoggy ofrecemos diferentes formas de ayudar a las mascotas necesitadas. 
                Desde adopción hasta voluntariado, cada acción cuenta para cambiar vidas.
            </p>
        </div>
    </section>

    <!-- Servicios Principales -->
    <section class="relative py-2">
        <div class="container mx-auto px-6">
            <!-- Adopción de Mascotas -->
            <div class="mb-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="rounded-full bg-gradient-to-br from-[#751629]/20 to-[#f56e5c]/20 dark:bg-primary/10 p-4 mr-4 backdrop-blur-sm">
                                <x-icons.medical-kit class="w-8 h-8 text-[#751629] dark:text-primary" />
                            </div>
                            <h2 class="text-3xl font-bold text-dark dark:text-white">Adopción de Mascotas</h2>
                        </div>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6 text-lg">
                            Encuentra tu compañero perfecto entre nuestras mascotas rescatadas. Cada adopción salva dos vidas: 
                            la del animal que adoptas y la del próximo que puede ocupar su lugar en el refugio.
                        </p>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-[#751629] to-[#f56e5c] mt-2 mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Proceso Simple</h4>
                                    <p class="text-gray-700 dark:text-gray-300">Registro, selección, entrevista y adopción responsable.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-[#751629] to-[#f56e5c] mt-2 mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Apoyo Continuo</h4>
                                    <p class="text-gray-700 dark:text-gray-300">Seguimiento post-adopción y asesoría veterinaria.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-[#751629] to-[#f56e5c] mt-2 mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-dark dark:text-white">Mascotas Preparadas</h4>
                                    <p class="text-gray-700 dark:text-gray-300">Vacunadas, desparasitadas y esterilizadas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('pets.index') }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 font-semibold">
                                Ver mascotas disponibles
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                            <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 alt="Adopción de mascotas" class="w-full h-80 object-cover">
                        </div>
                        <div class="absolute -bottom-4 -right-4 bg-gradient-to-r from-[#751629] to-[#f56e5c] rounded-xl p-4 shadow-xl backdrop-blur-sm">
                            <p class="text-white font-semibold text-sm">+500 adopciones exitosas</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donaciones -->
            <div class="mb-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <div class="bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                            <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 alt="Donaciones" class="w-full h-80 object-cover">
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <div class="flex items-center mb-6">
                            <div class="rounded-full bg-gradient-to-br from-[#f56e5c]/20 to-[#6b1f11]/20 dark:bg-secondary/10 p-4 mr-4 backdrop-blur-sm">
                                <x-icons.heart class="w-8 h-8 text-[#f56e5c] dark:text-secondary" />
                            </div>
                            <h2 class="text-3xl font-bold text-dark dark:text-white">Donaciones</h2>
                        </div>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6 text-lg">
                            Tu generosidad nos ayuda a mantener nuestros refugios funcionando y a brindar la mejor atención a las mascotas.
                            Cada donación, sin importar el tamaño, marca la diferencia.
                        </p>

                        <div class="space-y-6">
                            <!-- Donaciones Monetarias -->
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-6 rounded-2xl border border-[#f56e5c]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M11,17H13V16H14A1,1 0 0,0 15,15V12A1,1 0 0,0 14,11H10V9H15V7H13V6H11V7H10A1,1 0 0,0 9,8V11A1,1 0 0,0 10,12H14V14H9V16H11V17Z" />
                                    </svg>
                                    Donaciones Monetarias
                                </h4>
                                <p class="text-gray-700 dark:text-gray-300 mb-3">
                                    El 90% va directamente al refugio seleccionado, el 10% nos ayuda a mantener y mejorar la plataforma.
                                </p>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    • Gastos veterinarios • Alimentación • Mantenimiento de instalaciones
                                </div>
                            </div>

                            <!-- Donaciones en Especie -->
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-6 rounded-2xl border border-[#f56e5c]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-3 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19,3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
                                    </svg>
                                    Donaciones en Material
                                </h4>
                                <p class="text-gray-700 dark:text-gray-300 mb-3">
                                    Ropa, alimentos, medicinas y juguetes van 100% al refugio. Todo es aprovechado al máximo.
                                </p>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    • Alimento para perros y gatos • Mantas y camas • Juguetes • Medicamentos
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <a href="#" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#f56e5c] to-[#6b1f11] text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 font-semibold">
                                Hacer una donación
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Voluntariado -->
            <div class="mb-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="rounded-full bg-gradient-to-br from-[#6b1f11]/20 to-[#751629]/20 dark:bg-accent/10 p-4 mr-4 backdrop-blur-sm">
                                <x-icons.volunteer class="w-8 h-8 text-[#6b1f11] dark:text-accent" />
                            </div>
                            <h2 class="text-3xl font-bold text-dark dark:text-white">Voluntariado</h2>
                        </div>
                        
                        <p class="text-gray-700 dark:text-gray-300 mb-6 text-lg">
                            Únete a nuestro equipo de voluntarios y marca la diferencia directamente en la vida de las mascotas. 
                            Tu tiempo y dedicación son invaluables para nuestra misión.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-4 rounded-xl border border-[#6b1f11]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-2">Cuidado Directo</h4>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    Alimentación, limpieza, paseos y socialización de las mascotas.
                                </p>
                            </div>
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-4 rounded-xl border border-[#6b1f11]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-2">Eventos y Adopción</h4>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    Organización de eventos y ferias de adopción.
                                </p>
                            </div>
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-4 rounded-xl border border-[#6b1f11]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-2">Transporte</h4>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    Traslado de mascotas a citas veterinarias y adopciones.
                                </p>
                            </div>
                            <div class="bg-white/60 dark:bg-gray-700/60 backdrop-blur-sm p-4 rounded-xl border border-[#6b1f11]/20 shadow-lg">
                                <h4 class="font-semibold text-dark dark:text-white mb-2">Administración</h4>
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    Apoyo en tareas administrativas y redes sociales.
                                </p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-[#6b1f11]/10 to-[#751629]/10 dark:bg-accent/5 backdrop-blur-sm p-6 rounded-2xl mb-8 border border-[#6b1f11]/20">
                            <h4 class="font-semibold text-dark dark:text-white mb-3">Requisitos para ser voluntario:</h4>
                            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[#6b1f11] dark:text-accent" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" />
                                    </svg>
                                    Ser mayor de 18 años
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[#6b1f11] dark:text-accent" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" />
                                    </svg>
                                    Disponibilidad mínima de 4 horas semanales
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[#6b1f11] dark:text-accent" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" />
                                    </svg>
                                    Amor y respeto por los animales
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-[#6b1f11] dark:text-accent" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9,20.42L2.79,14.21L5.62,11.38L9,14.77L18.88,4.88L21.71,7.71L9,20.42Z" />
                                    </svg>
                                    Compromiso y responsabilidad
                                </li>
                            </ul>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('register') }}" 
                               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-[#751629] to-[#f56e5c] text-white rounded-xl hover:shadow-xl transition-all duration-300 transform hover:scale-105 font-semibold">
                                Únete como voluntario
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                            <img src="https://images.unsplash.com/photo-1559190394-df5a28aab5c5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                                 alt="Voluntariado" class="w-full h-80 object-cover">
                        </div>
                        <div class="absolute -bottom-4 -left-4 bg-gradient-to-r from-[#6b1f11] to-[#751629] rounded-xl p-4 shadow-xl backdrop-blur-sm">
                            <p class="text-white font-semibold text-sm">+120 voluntarios activos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    </div> <!-- Cierre del overlay dark -->

    <!-- Call to Action -->
    @guest
        <section class="relative py-20">
            <div class="absolute inset-0 bg-gradient-to-r from-[#751629] via-[#f56e5c] to-[#6b1f11] opacity-95"></div>
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative container mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold text-white mb-6">¿Listo para hacer la diferencia?</h2>
                <p class="text-white/90 mb-8 max-w-2xl mx-auto text-lg">
                    Únete a VitalDoggy y ayúdanos a salvar vidas. Cada acción cuenta, cada gesto importa.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('register') }}" 
                       class="px-8 py-4 rounded-xl bg-white text-[#751629] font-bold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
                        Registrarse
                    </a>
                    <a href="{{ route('pets.index') }}" 
                       class="px-8 py-4 rounded-xl bg-transparent border-2 border-white text-white font-bold hover:bg-white/10 transition-all duration-300 transform hover:scale-105">
                        Ver mascotas
                    </a>
                </div>
            </div>
        </section>
    @endguest
@endsection
