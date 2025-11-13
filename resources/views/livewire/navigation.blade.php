<div>
    <!-- Navigation -->
    <header class="relative z-10">
        <!-- Fondo gradiente que cambia según el modo -->
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-[#751629]/95 via-[#f56e5c]/95 via-100% to-[#6b1f11]/95 dark:bg-gradient-to-br dark:from-gray-900/95 dark:via-gray-800/95 dark:to-gray-700/95 backdrop-blur-[2px]"></div>
        <nav class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <a href="{{ $this->getLogoRoute() }}" class="flex items-center space-x-2 hover:opacity-80 transition duration-200">
                        <img src="{{ asset('logo.png') }}" alt="Logo VitalDoggy" class="w-20 h-20 object-contain">
                        <span class="text-2xl font-bold text-white dark:text-white">VitalDoggy</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-6">
                    <!-- Navigation Links -->
                    <nav class="flex items-center space-x-6">
                        @if(!$this->isAdmin() && !$this->isCaretaker())
                            <a href="{{ route('services.index') }}" 
                                class="{{ $this->isActiveRoute('services.*') ? 'text-primary dark:text-primary font-semibold' : 'text-white dark:text-white hover:text-orange-200 dark:hover:text-primary' }} transition duration-200 font-medium">
                                Servicios
                            </a>
                        @endif
                        <a href="{{ route('pets.index') }}" 
                            class="{{ $this->isActiveRoute(['pets.*', 'adoption.*']) ? 'text-primary dark:text-primary font-semibold' : 'text-white dark:text-white hover:text-orange-200 dark:hover:text-primary' }} transition duration-200 font-medium">
                            {{ $this->getPetsLinkText() }}
                        </a>
                        <a href="{{ $this->getSheltersRoute() }}" 
                            class="{{ $this->isActiveRoute('shelters.*') ? 'text-primary dark:text-primary font-semibold' : 'text-white dark:text-white hover:text-orange-200 dark:hover:text-primary' }} transition duration-200 font-medium">
                            {{ $this->getSheltersLinkText() }}
                            @if($this->isCaretaker() && $this->getCaretakerShelter())
                                <span class="text-xs opacity-75 block">{{ Str::limit($this->getCaretakerShelter()->name, 20) }}</span>
                            @endif
                        </a>
                        <a href="{{ route('donations.index') }}" 
                            class="{{ $this->isActiveRoute(['donations.*', 'donaciones.*']) ? 'text-primary dark:text-primary font-semibold' : 'text-white dark:text-white hover:text-orange-200 dark:hover:text-primary' }} transition duration-200 font-medium">
                            Donaciones
                        </a>
                    </nav>

                    <!-- Theme Toggle Button -->
                    <button wire:click="toggleTheme"
                        class="p-2 rounded-full hover:bg-white/20 dark:hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-white/50 dark:focus:ring-gray-400">
                        <x-icons.sun class="hidden dark:block w-5 h-5 text-yellow-400" />
                        <x-icons.moon class="block dark:hidden w-5 h-5 text-white" />
                    </button>

                    @if (Route::has('login'))
                        <div class="flex space-x-2 items-center">
                            @auth
                                <!-- Notificaciones (para el futuro) -->
                                @if($unreadCount > 0)
                                    <div class="relative">
                                        <button class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary relative">
                                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $unreadCount }}</span>
                                        </button>
                                    </div>
                                @endif

                                <!-- Profile Dropdown -->
                                <div class="relative">
                                    <button id="profile-dropdown-button" wire:click="toggleProfileDropdown" class="flex items-center px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200 focus:outline-none">
                                        <span class="mr-2">{{ Auth::user()->name }}</span>
                                        <svg class="w-4 h-4 transform transition-transform duration-200 {{ $showProfileDropdown ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    
                                    @if($showProfileDropdown)
                                        <div id="profile-dropdown-menu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                                            @if($this->isAdmin())
                                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <i class="fas fa-cog mr-2"></i>Panel de Administración
                                                </a>
                                                <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                            @endif
                                            
                                            
                                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-user mr-2"></i>Perfil
                                            </a>
                                            
                                            @if(!$this->isAdmin())
                                                <a href="{{ route('adoption.index') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <i class="fas fa-heart mr-2"></i>Mis Solicitudes
                                                </a>
                                                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-tachometer-alt mr-2"></i>Panel
                                            </a>
                                            @endif
                                            
                                            <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                            <button wire:click="logout" class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-4 py-2 rounded-lg bg-dark text-white hover:bg-dark/90 transition duration-200 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                    Iniciar sesión
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200">
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
                    <button wire:click="toggleTheme"
                        class="p-2 rounded-full hover:bg-white/20 dark:hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-white/50 dark:focus:ring-gray-400">
                        <x-icons.sun class="hidden dark:block w-5 h-5 text-yellow-400" />
                        <x-icons.moon class="block dark:hidden w-5 h-5 text-white" />
                    </button>

                    <!-- Hamburger Menu Button -->
                    <button wire:click="toggleMobileMenu"
                        class="p-2 rounded-md hover:bg-white/20 dark:hover:bg-gray-700/50 focus:outline-none focus:ring-2 focus:ring-white/50 dark:focus:ring-gray-400">
                        @if($showMobileMenu)
                            <x-icons.close class="w-6 h-6 text-white dark:text-white" />
                        @else
                            <x-icons.hamburger class="w-6 h-6 text-white dark:text-white" />
                        @endif
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            @if($showMobileMenu)
                <div class="lg:hidden mt-4 pb-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        @if (Route::has('login'))
                            @auth
                                <div class="p-4 space-y-3">
                                    @if($this->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="block w-full text-center px-4 py-3 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition duration-200 font-medium">
                                            <i class="fas fa-cog mr-2"></i>Panel de Administración
                                        </a>
                                        <a href="{{ route('user.dashboard') }}"
                                            class="block w-full text-center px-4 py-3 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200 font-medium">
                                            <i class="fas fa-tachometer-alt mr-2"></i>Panel Personal
                                        </a>
                                    @else
                                        <a href="{{ route('user.dashboard') }}"
                                            class="block w-full text-center px-4 py-3 rounded-lg bg-primary text-white hover:bg-primary/90 transition duration-200 font-medium">
                                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="p-4 space-y-3">
                                    <a href="{{ route('login') }}"
                                        class="block w-full text-center px-4 py-3 rounded-lg bg-dark text-white hover:bg-dark/90 border-gray-300 transition duration-200 font-medium dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
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
                            @if(!$this->isAdmin() && !$this->isCaretaker())
                                <a href="{{ route('services.index') }}" 
                                    class="{{ $this->isActiveRoute('services.*') ? 'bg-primary/10 text-primary border-l-4 border-primary font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} block px-4 py-2 rounded-md transition duration-200">
                                    Servicios
                                </a>
                            @endif
                            <a href="{{ route('pets.index') }}" 
                                class="{{ $this->isActiveRoute(['pets.*', 'adoption.*']) ? 'bg-primary/10 text-primary border-l-4 border-primary font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} block px-4 py-2 rounded-md transition duration-200">
                                {{ $this->getPetsLinkText() }}
                            </a>
                            <a href="{{ $this->getSheltersRoute() }}" 
                                class="{{ $this->isActiveRoute('shelters.*') ? 'bg-primary/10 text-primary border-l-4 border-primary font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} block px-4 py-2 rounded-md transition duration-200">
                                {{ $this->getSheltersLinkText() }}
                                @if($this->isCaretaker() && $this->getCaretakerShelter())
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $this->getCaretakerShelter()->name }}
                                    </div>
                                @endif
                            </a>
                            <a href="{{ route('donations.index') }}" 
                                class="{{ $this->isActiveRoute(['donations.*', 'donaciones.*']) ? 'bg-primary/10 text-primary border-l-4 border-primary font-semibold' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }} block px-4 py-2 rounded-md transition duration-200">
                                Donaciones
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </nav>
    </header>

    @script
    <script>
        // Manejar el tema en localStorage
        $wire.on('theme-changed', (event) => {
            if (event.theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            }
        });

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(e) {
            // Buscar por ID o clase específica en lugar de atributos wire
            const profileButton = e.target.closest('#profile-dropdown-button');
            const profileDropdown = e.target.closest('#profile-dropdown-menu');
            
            if (!profileButton && !profileDropdown) {
                $wire.call('closeDropdowns');
            }
        });
    </script>
    @endscript
</div>
