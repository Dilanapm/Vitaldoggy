<x-auth-layout>
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
            {{ __('Crear una cuenta') }}
        </h1>
        <p class="mt-2 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Ingresa tus datos para comenzar') }}
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" novalidate class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" 
                class="block mt-1 w-full" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Nombre de Usuario')" />
            <x-text-input id="username" 
                class="block mt-1 w-full" 
                type="text" 
                name="username" 
                :value="old('username')" 
                required 
                autocomplete="username" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sin espacios, solo letras, números, guiones y guiones bajos.</p>
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Teléfono')" />
            <x-text-input id="phone" 
                class="block mt-1 w-full" 
                type="text" 
                name="phone" 
                :value="old('phone')" 
                required 
                autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Dirección')" />
            <x-text-input id="address" 
                class="block mt-1 w-full" 
                type="text" 
                name="address" 
                :value="old('address')" 
                required 
                autocomplete="street-address" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full" 
                type="password" 
                name="password_confirmation" 
                required 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms of Service -->
        <div class="mt-4">
            <div class="p-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-md">
                <p class="text-xs text-gray-600 dark:text-gray-300">
                    Al registrarte, aceptas nuestros 
                    <a href="#" class="text-primary hover:text-primary/90 font-semibold hover:underline">Términos de Servicio</a> y 
                    <a href="#" class="text-primary hover:text-primary/90 font-semibold hover:underline">Política de Privacidad</a>.
                </p>
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:underline" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="ml-4 bg-primary hover:bg-primary/90">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-auth-layout>