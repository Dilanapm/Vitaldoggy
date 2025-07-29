<x-auth-layout>
    <div class="mb-5">
        <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
            {{ __('Iniciar sesión') }}
        </h1>
        <p class="mt-2 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Accede a tu cuenta') }}
        </p>
    </div>
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Contraseña')" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-primary hover:text-primary/90 hover:underline" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>
            <x-text-input id="password" 
                class="block mt-1 w-full" 
                type="password" 
                name="password" 
                required 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 dark:border-gray-700 text-primary focus:ring-primary dark:bg-gray-800 dark:focus:ring-offset-gray-800" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div>
            <x-primary-button class="w-full justify-center py-3 bg-primary hover:bg-primary/90">
                {{ __('Iniciar sesión') }}
            </x-primary-button>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('¿No tienes una cuenta?') }} 
                <a href="{{ route('register') }}" class="text-primary hover:text-primary/90 hover:underline">
                    {{ __('Regístrate') }}
                </a>
            </p>
        </div>
    </form>
</x-auth-layout>