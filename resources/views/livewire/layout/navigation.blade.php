<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Route;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    
    public function cartItemCount(): int
    {
        if (auth()->check()) {
            return \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
        } else {
            $sessionId = session()->getId();
            return \App\Models\CartItem::where('session_id', $sessionId)->sum('quantity');
        }
    }
}; ?>

<nav x-data="{ open: false }" class="bg-dark-900/95 backdrop-blur-sm border-b border-dark-800 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-white hover:text-brand transition-colors">
                        HoodieShop
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-dark-300 hover:text-white">
                        Home
                    </x-nav-link>
                </div>
            </div>

            <!-- Cart Icon -->
            <div class="hidden sm:flex sm:items-center">
                <a href="{{ route('cart.index') }}" class="relative text-dark-300 hover:text-white transition-colors p-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-brand rounded-full" x-data="{ count: {{ $this->cartItemCount() }} }" x-text="count" x-init="console.log(count)"></span>
                </a>
                
                <!-- Settings Dropdown -->
                <div class="ml-4 relative flex items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-dark-300 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name ?? 'Konto']) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            @auth
                                <x-dropdown-link :href="route('orders.index')" wire:navigate>
                                    {{ __('Meine Bestellungen') }}
                                </x-dropdown-link>
                            @endauth

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Abmelden') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-dark-300 hover:text-white hover:bg-dark-800 focus:outline-none focus:bg-dark-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-dark-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-dark-300 hover:text-white">
                Home
            </x-responsive-nav-link>
            
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 border-l-4 border-brand text-base font-medium text-white bg-dark-700 focus:outline-none focus:border-brand transition duration-150 ease-in-out">
                Warenkorb <span class="text-brand text-sm ml-2" x-data="{ count: {{ $this->cartItemCount() }} }" x-text="count"></span>
            </a>

            @auth
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    Meine Bestellungen
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-dark-700">
            <div class="px-4">
                <div class="font-medium text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name ?? 'Konto']) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-dark-400">{{ auth()->user()->email ?? '' }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Abmelden') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
