@props(['theme' => 'light'])

<!-- Navigation -->
<header class="relative z-10">
    <nav class="container mx-auto px-6 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="{{ asset('logo.png') }}" alt="Logo VitalDoggy" class="w-20 h-20 object-contain">
                <span class="text-2xl font-bold text-dark dark:text-white">VitalDoggy</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <!-- Navigation Links -->
                <nav class="flex items-center space-x-6">
                    <a href="#servicios" 
                        class="text-dark dark:text-white hover:text-orange-200 dark:hover:text-primary transition duration-200 font-medium">
                        Servicios
                    </a>
                    <a href="#" 
                        class="text-dark dark:text-white hover:text-orange-200 dark:hover:text-primary transition duration-200 font-medium">
                        Adopciones
                    </a>
                    <a href="#" 
                        class="text-dark dark:text-white hover:text-orange-200 dark:hover:text-primary transition duration-200 font-medium">
                        Donaciones
                    </a>
                    <a href="#" 
                        class="text-dark dark:text-white hover:text-orange-200 dark:hover:text-primary transition duration-200 font-medium">
                        Albergues
                    </a>
                </nav>

                <!-- Theme Toggle Button -->
                <button id="theme-toggle"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                    <x-icons.sun id="sun-icon" class="hidden dark:block w-5 h-5 text-yellow-400" />
                    <x-icons.moon id="moon-icon" class="block dark:hidden w-5 h-5 text-gray-500" />
                </button>

                @if (Route::has('login'))
                    <div class="flex space-x-2">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 rounded-lg bg-dark text-white hover:bg-dark/90 transition duration-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 rounded-lg  bg-primary text-white hover:bg-primary/90 transition duration-200">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Mobile Navigation Toggle -->
            <div class="lg:hidden flex items-center space-x-2">
                <!-- Theme Toggle Button Mobile -->
                <button id="theme-toggle-mobile"
                    class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                    <x-icons.sun id="sun-icon-mobile" class="hidden dark:block w-5 h-5 text-yellow-400" />
                    <x-icons.moon id="moon-icon-mobile" class="block dark:hidden w-5 h-5 text-gray-500" />
                </button>

                <!-- Hamburger Menu Button -->
                <button id="mobile-menu-toggle"
                    class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                    <x-icons.hamburger id="hamburger-icon" class="w-6 h-6 text-dark dark:text-white" />
                    <x-icons.close id="close-icon" class="hidden w-6 h-6 text-dark dark:text-white" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden mt-4 pb-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                @if (Route::has('login'))
                    @auth
                        <div class="p-4 space-y-3">
                            <a href="{{ url('/dashboard') }}"
                                class="block w-full text-center px-4 py-3 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200 font-medium">
                                Dashboard
                            </a>
                        </div>
                    @else
                        <div class="p-4 space-y-3">
                            <a href="{{ route('login') }}"
                                class="block w-full text-center px-4 py-3 rounded-lg  bg-dark text-white hover:bg-dark/90 border-gray-300  transition duration-200 font-medium dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                                Iniciar sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="block w-full text-center px-4 py-3 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200 font-medium">
                                    Registrarse
                                </a>
                            @endif
                        </div>
                    @endauth
                @endif

                <!-- Navigation Links -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-4 space-y-2">
                    <a href="#servicios" 
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-200">
                        Servicios
                    </a>
                    <a href="#" 
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-200">
                        Adopciones
                    </a>
                    <a href="#" 
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-200">
                        Donaciones
                    </a>
                    <a href="#" 
                        class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition duration-200">
                        Albergues
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>
