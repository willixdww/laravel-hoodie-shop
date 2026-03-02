<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Hoodie & Jeans Shop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans bg-dark-900 text-dark-100 antialiased">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 backdrop-blur-md bg-dark-900/95 border-b border-dark-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-brand hover:text-brand-light transition-colors">
                            HoodieShop
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-8">
                        <a href="{{ route('home') }}" class="text-dark-100 hover:text-brand transition-colors">
                            Home
                        </a>
                        <a href="#featured" class="text-dark-100 hover:text-brand transition-colors">
                            Produkte
                        </a>
                        <a href="#categories" class="text-dark-100 hover:text-brand transition-colors">
                            Kategorien
                        </a>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Cart Icon with Badge -->
                        <div class="relative">
                            <a href="{{ route('cart.index') }}" class="text-dark-100 hover:text-brand transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span id="cart-badge" class="absolute -top-2 -right-2 h-5 w-5 flex items-center justify-center bg-brand text-white text-xs rounded-full">
                                    {{ session('cart_count', 0) }}
                                </span>
                            </a>
                        </div>

                        <!-- Mobile Menu Button -->
                        <button id="mobile-menu-btn" class="md:hidden text-dark-100 hover:text-brand transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-dark-800 border-b border-dark-700">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-dark-100 hover:text-brand hover:bg-dark-700 rounded-md">
                        Home
                    </a>
                    <a href="#featured" class="block px-3 py-2 text-dark-100 hover:text-brand hover:bg-dark-700 rounded-md">
                        Produkte
                    </a>
                    <a href="#categories" class="block px-3 py-2 text-dark-100 hover:text-brand hover:bg-dark-700 rounded-md">
                        Kategorien
                    </a>
                    <a href="{{ route('cart.index') }}" class="block px-3 py-2 text-dark-100 hover:text-brand hover:bg-dark-700 rounded-md">
                        Warenkorb
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-16">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-dark-800 border-t border-dark-700 mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold text-brand mb-4">HoodieShop</h3>
                        <p class="text-dark-300 text-sm">
                            Premium Hoodies & Jeans für jeden Tag - hochwertig, nachhaltig, fair produziert.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-dark-100 mb-4">Shop</h4>
                        <ul class="space-y-2 text-sm text-dark-300">
                            <li><a href="{{ route('home') }}" class="hover:text-brand">Neuankömmlinge</a></li>
                            <li><a href="{{ route('home') }}" class="hover:text-brand">Bestseller</a></li>
                            <li><a href="{{ route('home') }}" class="hover:text-brand">Sale</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-dark-100 mb-4">Support</h4>
                        <ul class="space-y-2 text-sm text-dark-300">
                            <li><a href="#" class="hover:text-brand">Kontakt</a></li>
                            <li><a href="#" class="hover:text-brand">Versand & Rückgabe</a></li>
                            <li><a href="#" class="hover:text-brand">Größenführer</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-dark-100 mb-4">Newsletter</h4>
                        <p class="text-dark-300 text-sm mb-4">Melde dich an für exklusive Angebote</p>
                        <div class="flex">
                            <input type="email" placeholder="Deine Email" class="bg-dark-700 text-dark-100 px-4 py-2 rounded-l-md focus:outline-none focus:border-brand w-full text-sm">
                            <button class="bg-brand text-white px-4 py-2 rounded-r-md hover:bg-brand-light transition-colors text-sm">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-dark-700 text-center text-dark-300 text-sm">
                    &copy; {{ date('Y') }} HoodieShop. Alle Rechte vorbehalten.
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script>
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Cart animation on add
            function animateCartBadge() {
                const badge = document.getElementById('cart-badge');
                badge.classList.add('animate-pulse');
                setTimeout(() => {
                    badge.classList.remove('animate-pulse');
                }, 500);
            }
        </script>
    </body>
</html>
