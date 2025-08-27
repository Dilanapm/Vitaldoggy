<!-- Footer -->
<footer class="bg-gray-900 dark:bg-black text-white py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <img src="{{ asset('logo.png') }}" alt="Logo VitalDoggy" class="w-20 h-20 object-contain">
                    <span class="text-xl font-bold">VitalDoggy</span>
                </div>
                <p class="text-gray-400">
                    Conectando mascotas con hogares amorosos desde 2023.
                </p>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Enlaces rápidos</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition">Inicio</a></li>
                    <li><a href="{{ route('services.index') }}" class="hover:text-primary transition">Servicios</a></li>
                    <li><a href="{{ route('pets.index') }}" class="hover:text-primary transition">Adopciones</a></li>
                    <li><a href="{{ route('shelters.index') }}" class="hover:text-primary transition">Refugios</a></li>
                    <li><a href="#" class="hover:text-primary transition">Donaciones</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-primary transition">Términos de uso</a></li>
                    <li><a href="#" class="hover:text-primary transition">Política de privacidad</a></li>
                    <li><a href="#" class="hover:text-primary transition">Cookies</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                        </svg>
                        <span>contacto@vitaldoggy.com</span>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
                        </svg>
                        <span>+123 456 7890</span>
                    </li>
                </ul>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-primary">
                        <x-icons.instagram class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary">
                        <x-icons.twitter class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary">
                        <x-icons.facebook class="w-6 h-6" />
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-400">
            <p>© {{ date('Y') }} VitalDoggy. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>
