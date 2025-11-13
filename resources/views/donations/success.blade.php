@extends('layouts.base')

@section('title', 'Donación Completada - VitalDoggy')
@section('description', 'Tu donación ha sido recibida exitosamente. Gracias por ayudar a salvar vidas de mascotas abandonadas.')

@section('content')
<div class="min-h-screen dark:bg-gray-900/75 py-16">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center">
            <!-- Ícono de éxito -->
            <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-8">
                <i class="fas fa-check-circle text-4xl text-green-600 dark:text-green-400"></i>
            </div>

            <!-- Mensaje principal -->
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                ¡Gracias por tu generosidad!
            </h1>
            
            <p class="text-xl text-gray-700 dark:text-gray-300 mb-8">
                Tu donación ha sido procesada exitosamente. Cada peso cuenta para salvar vidas de mascotas que necesitan amor y cuidado.
            </p>

            <!-- Resumen de la donación -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-8 mb-8">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">
                    Resumen de tu donación
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Donante</span>
                        <span class="text-lg text-gray-900 dark:text-white">{{ $donationData['donor_name'] }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Email</span>
                        <span class="text-lg text-gray-900 dark:text-white">{{ $donationData['donor_email'] }}</span>
                    </div>
                    
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Tipo de donación</span>
                        <span class="text-lg text-gray-900 dark:text-white capitalize">
                            @switch($donationData['donation_type'])
                                @case('money') Monetaria @break
                                @case('food') Alimento @break
                                @case('medicine') Medicina @break
                                @case('supplies') Suministros @break
                                @default Otro tipo de ayuda @break
                            @endswitch
                        </span>
                    </div>
                    
                    @if($donationData['donation_type'] === 'money' && isset($donationData['amount']))
                    <div>
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Monto</span>
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($donationData['amount'], 2) }}</span>
                    </div>
                    @endif
                    
                    @if(isset($donationData['shelter_id']) && $donationData['shelter_id'])
                        @php
                            $shelter = \App\Models\Shelter::find($donationData['shelter_id']);
                        @endphp
                        @if($shelter)
                        <div class="md:col-span-2">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Refugio destinatario</span>
                            <span class="text-lg text-gray-900 dark:text-white">{{ $shelter->name }} - {{ $shelter->city }}</span>
                        </div>
                        @endif
                    @else
                    <div class="md:col-span-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Destinatario</span>
                        <span class="text-lg text-gray-900 dark:text-white">Donación general (se distribuye según necesidades)</span>
                    </div>
                    @endif
                    
                    @if(isset($donationData['message']) && $donationData['message'])
                    <div class="md:col-span-2">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400 block">Tu mensaje</span>
                        <p class="text-lg text-gray-900 dark:text-white italic">"{{ $donationData['message'] }}"</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Próximos pasos -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300 mb-4">
                    <i class="fas fa-info-circle mr-2"></i>
                    ¿Qué sigue ahora?
                </h3>
                <div class="text-left space-y-3">
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-blue-600 dark:text-blue-400 mt-1 mr-3"></i>
                        <span class="text-blue-800 dark:text-blue-400">
                            Recibirás un email de confirmación con los detalles de tu donación.
                        </span>
                    </div>
                    @if($donationData['donation_type'] === 'money')
                    <div class="flex items-start">
                        <i class="fas fa-credit-card text-blue-600 dark:text-blue-400 mt-1 mr-3"></i>
                        <span class="text-blue-800 dark:text-blue-400">
                            El procesamiento del pago puede tomar de 1 a 3 días hábiles.
                        </span>
                    </div>
                    @endif
                    <div class="flex items-start">
                        <i class="fas fa-heart text-blue-600 dark:text-blue-400 mt-1 mr-3"></i>
                        <span class="text-blue-800 dark:text-blue-400">
                            Te mantendremos informado sobre el impacto de tu donación.
                        </span>
                    </div>
                    @if($donationData['donation_type'] !== 'money')
                    <div class="flex items-start">
                        <i class="fas fa-phone text-blue-600 dark:text-blue-400 mt-1 mr-3"></i>
                        <span class="text-blue-800 dark:text-blue-400">
                            Un representante se contactará contigo para coordinar la entrega de tu donación.
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Impacto de la donación -->
            @if($donationData['donation_type'] === 'money' && isset($donationData['amount']))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-green-900 dark:text-green-300 mb-4">
                    <i class="fas fa-paw mr-2"></i>
                    El impacto de tu donación
                </h3>
                <div class="text-green-800 dark:text-green-400">
                    @php $amount = floatval($donationData['amount']); @endphp
                    @if($amount >= 200)
                        <p>¡Increíble! Tu donación de ${{ number_format($amount, 2) }} puede <strong>rescatar y rehabilitar completamente una mascota</strong>, incluyendo gastos médicos, alimentación y cuidados hasta su adopción.</p>
                    @elseif($amount >= 100)
                        <p>¡Excelente! Con ${{ number_format($amount, 2) }} puedes <strong>financiar una cirugía de esterilización completa</strong> y contribuir significativamente al bienestar de una mascota.</p>
                    @elseif($amount >= 50)
                        <p>¡Genial! Tu donación de ${{ number_format($amount, 2) }} puede <strong>cubrir una consulta veterinaria completa</strong> y exámenes básicos para una mascota.</p>
                    @elseif($amount >= 25)
                        <p>¡Fantástico! Con ${{ number_format($amount, 2) }} puedes <strong>alimentar a una mascota por una semana completa</strong> con comida nutritiva y de calidad.</p>
                    @else
                        <p>¡Gracias! Tu donación de ${{ number_format($amount, 2) }} ayuda a <strong>cubrir necesidades básicas diarias</strong> como alimentación y cuidados de las mascotas.</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Acciones adicionales -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('pets.index') }}" 
                   class="px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-primary/90 transition duration-200">
                    <i class="fas fa-heart mr-2"></i>Ver mascotas en adopción
                </a>
                
                <a href="{{ route('donations.create') }}" 
                   class="px-6 py-3 border-2 border-primary text-primary font-medium rounded-lg hover:bg-primary hover:text-white transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Hacer otra donación
                </a>
                
                <a href="{{ route('home') }}" 
                   class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                    <i class="fas fa-home mr-2"></i>Volver al inicio
                </a>
            </div>

            <!-- Compartir en redes sociales -->
            <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Comparte y motiva a otros
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Ayúdanos a llegar a más personas que quieran hacer una diferencia en la vida de las mascotas.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('donations.index')) }}" 
                       target="_blank"
                       class="p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-200">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('Acabo de hacer una donación para ayudar a mascotas abandonadas en VitalDoggy. ¡Únete a esta noble causa!') }}&url={{ urlencode(route('donations.index')) }}" 
                       target="_blank"
                       class="p-3 bg-blue-400 text-white rounded-full hover:bg-blue-500 transition duration-200">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode('Acabo de hacer una donación para ayudar a mascotas abandonadas. Puedes hacerlo también en: ' . route('donations.index')) }}" 
                       target="_blank"
                       class="p-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition duration-200">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection