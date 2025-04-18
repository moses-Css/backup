<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

<nav x-data="{ open: false }" class="p-4 bg-secondary text-neutraldark dark:text-secondary sticky top-0 z-50 dark:bg-neutralDark border-b border-neutralGray2 dark:border-neutralGray2 ">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:flex justify-between items-center"> <!-- Ensure both items are on the edges -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <!-- Logo content here -->
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class=" text-neutraldark dark:text-secondary hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <!-- <button @click="darkMode = !darkMode"
                        class="mb-4 p-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-start">
                        <template x-if="darkMode">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3v1m0 16v1m8.485-8.485h-1m-14.97 0h-1m11.314-6.364l-.707.707m-8.486 8.486l-.707.707m0-11.314l.707.707m8.486 8.486l.707.707M12 6.25a5.75 5.75 0 100 11.5 5.75 5.75 0 000-11.5z">
                                </path>
                            </svg>
                        </template>
                        <template x-if="!darkMode">
                            <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 2a9.003 9.003 0 000 18c4.97 0 9-4.03 9-9S16.97 2 12 2z"></path>
                            </svg>
                        </template>
                        <span x-text="darkMode ? 'Dark Mode' : 'Light Mode'" class="ml-2"></span>
                    </button> -->

                    @if(auth()->check())
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @else
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('BKKBN.Galeri') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="url('/')" :active="request()->routeIs('/')" wire:navigate>
                        {{ __('Beranda') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/')" :active="request()->routeIs('/')" wire:navigate>
                        {{ __('Kategori') }}
                    </x-nav-link>
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('/')" wire:navigate>
                        {{ __('Foto') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown and Login Button -->
            <div class="items-center ms-auto hidden sm:flex"> <!-- Push the items to the right side -->
                @if(auth()->check())
                <div class="sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-neutralgray dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <!-- Avatar & Name -->
                                <div class="flex items-center space-x-2">
                                    <div class="size-8 rounded-full bg-gradient-to-r from-blue-500 to-sky-400 flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div x-data="{ name: '{{ auth()->check() ? auth()->user()->name : 'Guest' }}' }"
                                        x-text="name"
                                        x-on:profile-updated.window="name = $event.detail.name">
                                    </div>
                                </div>

                                <!-- Dropdown Icon -->
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>

                </div>
                @else
                <!-- Login Button -->
                <div class="hidden md:flex items-center ms-auto"> <!-- Ganti 'hidden' dengan 'md:flex' -->
                    <button class="items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-neutralDark hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <a href="/login">Login</a>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Hamburger -->
    <div class="!p-0" x-data="{ open: false }">
        <!-- Header dengan hamburger -->
        <div class="flex items-center sm:hidden w-full flex-row justify-between bg-secondary dark:bg-neutralDark">

            <a class="text-neutraldark dark:text-secondary" href="/">BKKBN<span class="font-bold text-sm">.Galeri</span></a>
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-neutraldark dark:text-secondary hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="#1e1e1e" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Responsive Navigation Menu dengan transisi max-height -->
        <div x-ref="menu" :style="open ? `max-height: ${$refs.menu.scrollHeight}px` : 'max-height: 0px'"
            class="sm:hidden bg-secondary  dark:bg-neutralDark overflow-hidden transition-all duration-500 ease-[cubic-bezier(0.93,0.55,0.13,0.8)]">
            <div class="pt-4 border-t border-gray-200 dark:border-gray-600 mx-auto">
                <!-- Jika user sudah login -->
                @if(auth()->check())
                <div class="mb-2 w-full items-center mx-auto capitalize justify-center text-center flex">
                    <span>Halo,<span></span> </span>
                    <div class="font-bold text-base text-neutraldark dark:text-secondary"
                        x-data="{ name: '{{ auth()->user()->name ?? 'Guest' }}' }"
                        x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name">
                    </div>
                </div>
                @endif

                <div class="space-y-1 pb-4 px-8">
                    @if(auth()->check())
                    <x-responsive-nav-link :href="route('dashboard')" wire:navigate>

                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>

                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    @endif

                    <x-responsive-nav-link :href="route('welcome')" wire:navigate>
                        {{__('Beranda')}}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{__('Kategori')}}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{__('Foto')}}
                    </x-responsive-nav-link>
                    <p class="items-center text-neutralGray  mx-auto w-full justify-center text-center pt-4">Partner</p>
                    @if(auth()->check())

                    <!-- Tombol Logout and Login -->
                    <!-- <button wire:click="logout" extraclass="">
                    <x-responsive-nav-link :class="'bg-neutralDark text-secondary dark:text-neutralDark hover:bg-neutrallight dark:hover:bg-neutralDark py-0 rounded-xl'">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link> 
                </button> -->
                    <button wire:click="logout" :class="'w-full justify-center items-center mx-auto text-center bg-Dangerneutral text-secondary dark:text-dangerneutral hover:bg-neutrallight dark:hover:bg-neutralDark py-0 rounded-xl'">
                        <x-responsive-nav-link :href="route('login')" wire:navigate>
                            {{ __('Logout') }}
                        </x-responsive-nav-link>
                    </button>
                    @else
                    <x-responsive-nav-link :href="route('login')" wire:navigate :class="'bg-neutralDark text-secondary dark:text-neutralDark hover:bg-neutrallight dark:hover:bg-neutralDark py-0 rounded-xl'">
                        {{ __('Login') }}
                    </x-responsive-nav-link>


                    @endif
                </div>
            </div>
        </div>
    </div>


</nav>