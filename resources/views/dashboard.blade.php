<x-app-layout>

    <nav class="w-full flex items-center justify-between border-b p-6 sticky top-0 z-30 bg-secondary">
        <!-- Hamburger Menu (Mobile) -->
        <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-full hover:bg-gray-200 transition">
            ☰
        </button>

        <!-- Title -->
        <div class="text-center md:text-left flex-1">
            <h1 class="text-sm sm:text-lg font-light">Halo, {{ auth()->user()->name }}</h1>
            <x-head-hero>
                {{__('Partner Dashboard')}}
            </x-head-hero>
        </div>

        <!-- Search Input -->
        <div class="hidden md:flex flex-1 justify-center">
            <input type="text" placeholder="Cari" class="w-3/5 md:w-2/3 lg:w-1/2 p-2 rounded-full border border-gray-300">
        </div>

        <!-- Search Button & Profile (Mobile & Desktop) -->
        <div class="flex items-center gap-4">
            <!-- Mobile Search Button -->
            <button class="h-10 w-10 rounded-full border border-gray-300 flex items-center justify-center md:hidden">
                🔍
            </button>

            <!-- Profile Dropdown (Hidden on Mobile) -->
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="hidden md:inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-neutralgray dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
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
    </nav>

    @if (session('success'))
    <div x-data="{ show: true, progress: 100 }"
        x-show="show"
        x-transition:enter="transform transition duration-500 ease-out"
        x-transition:enter-start="-translate-y-20 opacity-0 scale-90"
        x-transition:enter-end="translate-y-0 opacity-100 scale-100"
        x-transition:leave="transform transition duration-300 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 scale-100"
        x-transition:leave-end="-translate-y-20 opacity-0 scale-90"
        x-init="
        let interval = setInterval(() => {
            progress -= 1.5;
            if (progress <= 0) {
                clearInterval(interval);
                show = false;
            }
        }, 60);"
        class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-primary to-sky-400 text-white px-6 py-4 rounded-lg shadow-xl z-50 w-auto flex items-center gap-3">

        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256">
            <path d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"></path>
        </svg>

        <!-- Text -->
        <span class="font-semibold text-lg whitespace-nowrap">{{ session('success') }}</span>

        <!-- Close Button -->
        <button @click="show = false" class="ml-auto focus:outline-none shrink-0">
            <svg class="w-5 h-5 hover:scale-110 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 w-full h-1 rounded-b-lg overflow-hidden">
            <div class="h-full bg-white transition-all duration-75"
                x-bind:style="'width: ' + progress + '%'">
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 w-full">
    <!-- Statistik 1 -->
    <div class="relative bg-primary text-secondary rounded-3xl p-8 h-full flex flex-col justify-between overflow-hidden">
        <div>
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl md:text-3xl font-medium">Total Foto</h2>
                    <p>Rekap tahun {{ now()->year }}</p>
                </div>
                <div class="hidden md:flex border rounded-full p-2 items-center">
                    <x-icon name="arrow-up-white" />
                </div>
            </div>
        </div>
        <h1 class="text-6xl md:text-7xl font-medium">{{ $totalImages }}</h1>
    </div>

    <!-- Statistik 2 -->
    <div class="relative text-neutralDark rounded-3xl p-8 h-full flex flex-col justify-between overflow-hidden border">
        <div>
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl md:text-3xl font-medium">Total Kategori</h2>
                    <p>Rekap tahun {{ now()->year }}</p>
                </div>
                <div class="hidden md:flex border rounded-full p-2 items-center">
                    <x-icon name="arrow-up-white" />
                </div>
            </div>
        </div>
        <h1 class="text-6xl md:text-7xl font-medium">{{ $totalCategories }}</h1>
    </div>

    <!-- Statistik 3 -->
    <div class="relative bg-primary text-secondary rounded-3xl p-8 h-full flex flex-col justify-between overflow-hidden">
        <div>
            <div class="flex justify-between">
                <div>
                    <h2 class="text-xl md:text-3xl font-medium">Total User</h2>
                    <p>Rekap tahun {{ now()->year }}</p>
                </div>
                <div class="hidden md:flex border rounded-full p-2 items-center">
                    <x-icon name="arrow-up-white" />
                </div>
            </div>
        </div>
        <h1 class="text-6xl md:text-7xl font-medium">{{ $totalUsers }}</h1>
    </div>

    <!-- File Explorer - Full Width -->
    <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:min-h-screen lg:col-span-full border rounded-xl flex flex-col p-10">
        <livewire:file-explorer />
    </div>
</div>

</x-app-layout>