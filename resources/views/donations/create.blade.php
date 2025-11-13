@extends('layouts.base')

@section('title', 'Hacer una Donación - VitalDoggy')
@section('description', 'Completa tu donación para ayudar a salvar vidas de mascotas abandonadas. Proceso seguro y transparente.')

@section('content')
<div class="min-h-screen dark:bg-gray-900/75 py-12">
    <div class="container mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('donations.index') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a donaciones
                </a>
            </div>
            
            <div class="text-center mb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    @if($shelter)
                        Donar a {{ $shelter->name }}
                    @else
                        Hacer una Donación
                    @endif
                </h1>
                <p class="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                    Tu generosidad marca la diferencia. Completa el formulario para hacer tu donación de manera segura.
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <form action="{{ route('donations.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Información del refugio si está seleccionado -->
                @if($shelter)
                    <input type="hidden" name="shelter_id" value="{{ $shelter->id }}">
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($shelter->hasImage())
                                    <img src="{{ $shelter->image_url }}" 
                                         alt="{{ $shelter->name }}"
                                         class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 bg-blue-200 dark:bg-blue-800 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-home text-2xl text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300">{{ $shelter->name }}</h3>
                                <p class="text-blue-800 dark:text-blue-400">
                                    <i class="fas fa-map-marker-alt mr-1"></i>{{ $shelter->city }}
                                </p>
                                @if($shelter->description)
                                    <p class="text-sm text-blue-700 dark:text-blue-500 mt-1">{{ Str::limit($shelter->description, 120) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Selector de refugio -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                            <i class="fas fa-home text-primary mr-2"></i>
                            Refugio destinatario
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    ¿A qué refugio quieres dirigir tu donación?
                                </label>
                                <select name="shelter_id" id="shelter_id" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="">Donación general (se distribuye según necesidades)</option>
                                    @foreach($shelters as $shelterOption)
                                        <option value="{{ $shelterOption->id }}">
                                            {{ $shelterOption->name }} - {{ $shelterOption->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Información del donante -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-user text-primary mr-2"></i>
                        Información del donante
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="donor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre completo *
                            </label>
                            <input type="text" name="donor_name" id="donor_name" required
                                   value="{{ old('donor_name', auth()->user()->name ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="Tu nombre completo">
                            @error('donor_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="donor_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Correo electrónico *
                            </label>
                            <input type="email" name="donor_email" id="donor_email" required
                                   value="{{ old('donor_email', auth()->user()->email ?? '') }}"
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                   placeholder="tu@email.com">
                            @error('donor_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tipo y monto de donación -->
                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-gift text-primary mr-2"></i>
                        Detalles de la donación
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Tipo de donación -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Tipo de donación *
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="donation-type-option">
                                    <input type="radio" name="donation_type" value="money" 
                                           {{ old('donation_type', request('type')) === 'money' ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="donation-type-card">
                                        <i class="fas fa-donate text-green-600 text-xl mb-2"></i>
                                        <span class="font-medium">Dinero</span>
                                    </div>
                                </label>
                                <label class="donation-type-option">
                                    <input type="radio" name="donation_type" value="food" 
                                           {{ old('donation_type', request('type')) === 'food' ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="donation-type-card">
                                        <i class="fas fa-utensils text-orange-600 text-xl mb-2"></i>
                                        <span class="font-medium">Alimento</span>
                                    </div>
                                </label>
                                <label class="donation-type-option">
                                    <input type="radio" name="donation_type" value="medicine" 
                                           {{ old('donation_type', request('type')) === 'medicine' ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="donation-type-card">
                                        <i class="fas fa-heartbeat text-red-600 text-xl mb-2"></i>
                                        <span class="font-medium">Medicina</span>
                                    </div>
                                </label>
                                <label class="donation-type-option md:col-span-1">
                                    <input type="radio" name="donation_type" value="supplies" 
                                           {{ old('donation_type', request('type')) === 'supplies' ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="donation-type-card">
                                        <i class="fas fa-box text-blue-600 text-xl mb-2"></i>
                                        <span class="font-medium">Suministros</span>
                                    </div>
                                </label>
                                <label class="donation-type-option md:col-span-2">
                                    <input type="radio" name="donation_type" value="other" 
                                           {{ old('donation_type', request('type')) === 'other' ? 'checked' : '' }}
                                           class="sr-only" required>
                                    <div class="donation-type-card">
                                        <i class="fas fa-heart text-purple-600 text-xl mb-2"></i>
                                        <span class="font-medium">Otro tipo de ayuda</span>
                                    </div>
                                </label>
                            </div>
                            @error('donation_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Monto (solo para donaciones monetarias) -->
                        <div id="amount-section" class="hidden">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Monto de la donación *
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400">$</span>
                                <input type="number" name="amount" id="amount" min="1" step="0.01"
                                       value="{{ old('amount') }}"
                                       class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                       placeholder="0.00">
                            </div>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            <!-- Sugerencias de monto -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                <button type="button" onclick="setAmount(10)" 
                                        class="amount-btn px-3 py-1 text-sm rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    $10
                                </button>
                                <button type="button" onclick="setAmount(25)" 
                                        class="amount-btn px-3 py-1 text-sm rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    $25
                                </button>
                                <button type="button" onclick="setAmount(50)" 
                                        class="amount-btn px-3 py-1 text-sm rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    $50
                                </button>
                                <button type="button" onclick="setAmount(100)" 
                                        class="amount-btn px-3 py-1 text-sm rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    $100
                                </button>
                                <button type="button" onclick="setAmount(200)" 
                                        class="amount-btn px-3 py-1 text-sm rounded-lg border border-gray-300 hover:bg-gray-100 dark:border-gray-600 dark:hover:bg-gray-700">
                                    $200
                                </button>
                            </div>
                        </div>

                        <!-- Mensaje opcional -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mensaje opcional
                            </label>
                            <textarea name="message" id="message" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-700 text-gray-900 dark:text-white resize-none"
                                      placeholder="Mensaje de apoyo para el refugio (opcional)">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Método de pago -->
                <div id="payment-section" class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-lg shadow-lg border border-gray-200/50 dark:border-gray-700/50 p-6 hidden">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-credit-card text-primary mr-2"></i>
                        Método de pago
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="card" class="sr-only" required>
                            <div class="payment-method-card">
                                <i class="fas fa-credit-card text-blue-600 text-xl mb-2"></i>
                                <span class="font-medium">Tarjeta de crédito/débito</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="bank_transfer" class="sr-only" required>
                            <div class="payment-method-card">
                                <i class="fas fa-university text-green-600 text-xl mb-2"></i>
                                <span class="font-medium">Transferencia bancaria</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="paypal" class="sr-only" required>
                            <div class="payment-method-card">
                                <i class="fab fa-paypal text-blue-500 text-xl mb-2"></i>
                                <span class="font-medium">PayPal</span>
                            </div>
                        </label>
                        <label class="payment-method-option">
                            <input type="radio" name="payment_method" value="other" class="sr-only" required>
                            <div class="payment-method-card">
                                <i class="fas fa-wallet text-purple-600 text-xl mb-2"></i>
                                <span class="font-medium">Otro método</span>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones de acción -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-6">
                    <a href="{{ route('donations.index') }}" 
                       class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200 text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-[#216300] to-[#185514] text-white font-medium rounded-lg hover:from-[#5cb132]/70 hover:to-[#185514]/70 transition duration-200 shadow-lg">
                        <i class="fas fa-heart mr-2"></i>Completar donación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.donation-type-card, .payment-method-card {
    @apply p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg text-center cursor-pointer transition-all duration-200 hover:border-primary hover:bg-primary/5;
}

.donation-type-option input:checked + .donation-type-card,
.payment-method-option input:checked + .payment-method-card {
    @apply border-primary bg-primary/10 dark:bg-primary/20;
}

.amount-btn {
    @apply text-gray-700 dark:text-gray-300;
}
</style>

<script>
// Mostrar/ocultar sección de monto según el tipo de donación
document.addEventListener('DOMContentLoaded', function() {
    const donationTypeInputs = document.querySelectorAll('input[name="donation_type"]');
    const amountSection = document.getElementById('amount-section');
    const paymentSection = document.getElementById('payment-section');
    const amountInput = document.getElementById('amount');

    donationTypeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'money') {
                amountSection.classList.remove('hidden');
                paymentSection.classList.remove('hidden');
                amountInput.required = true;
            } else {
                amountSection.classList.add('hidden');
                paymentSection.classList.add('hidden');
                amountInput.required = false;
                amountInput.value = '';
            }
        });
    });

    // Verificar estado inicial
    const checkedType = document.querySelector('input[name="donation_type"]:checked');
    if (checkedType && checkedType.value === 'money') {
        amountSection.classList.remove('hidden');
        paymentSection.classList.remove('hidden');
        amountInput.required = true;
    }
});

// Función para establecer monto sugerido
function setAmount(amount) {
    document.getElementById('amount').value = amount;
}
</script>

@endsection