<x-guest-layout>
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <!-- Icono de correo electrónico -->
            <div class="text-center mb-6">
                <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <!-- Título -->
            <h2 class="mt-2 text-center text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ __('Verifica tu correo electrónico') }}
            </h2>

            <!-- Mensaje principal -->
            <div class="mt-4 mb-6 text-sm text-center text-gray-600 dark:text-gray-300">
                {{ __('¡Gracias por registrarte en VitalDoggy! Antes de comenzar, necesitamos verificar tu dirección de correo electrónico.') }}
                <br><br>
                {{ __('Hemos enviado un enlace de verificación a') }} <strong class="dark:text-white">{{ auth()->user()->email }}</strong>
                <br>
                {{ __('Por favor, revisa tu bandeja de entrada y haz clic en el enlace para activar tu cuenta.') }}
            </div>

            <!-- Notificación de email enviado -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 rounded-md bg-green-50 dark:bg-green-800/30 border border-green-200 dark:border-green-700">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">
                                {{ __('¡Enlace enviado! Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botones de acción -->
            <div class="flex flex-col gap-4">
                <!-- Reenviar email -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="w-full justify-center">
                        {{ __('Reenviar email de verificación') }}
                    </x-primary-button>
                </form>

                <!-- Volver atrás -->
                <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Volver a la página de inicio') }}
                </a>
            </div>

            <!-- Consejos adicionales -->
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-md">
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('¿No recibiste el correo?') }}</h3>
                <div class="mt-2 text-xs text-gray-600 dark:text-gray-300">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>{{ __('Revisa tu carpeta de spam o correo no deseado.') }}</li>
                        <li>{{ __('Asegúrate de que la dirección de correo proporcionada sea correcta.') }}</li>
                        <li>{{ __('Espera unos minutos antes de solicitar un nuevo enlace.') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>