<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('Partner - Dashboard', 'Partner - Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <link href="{{ secure_asset('/build/assets/app.css') }}" rel="stylesheet">
    <script src="{{ secure_asset('/build/assets/app.js') }}"></script> -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>




</head>
@php
$currentRoute = Route::currentRouteName();
@endphp

<body class="font-urbanist antialiased bg-secondary ">
    <x-sidebar />
    <x-kategori-modal />
    <x-foto-modal />

    <!-- Main Content Area -->
    <div class="min-h-screen md:ml-64 flex flex-col overflow-y-auto"> <!-- Perubahan disini -->
        @if ($currentRoute !== 'dashboard')
        <livewire:layout.navigation />
        @endif

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-secondary dark:bg-neutralDark">
            <div class="py-24 px-10 sm:px-6 lg:px-8 text-2xl justify-center items-center text-center mx-auto">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="flex-grow"> <!-- Perubahan disini -->
            {{ $slot }}
        </main>

        <!-- Footer dipindah ke dalam container -->
        <x-footers />
    </div>

    @livewireScripts
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("-translate-x-full");
        }

        // Menutup sidebar jika klik di luar (khusus untuk mobile)
        document.addEventListener("click", function(event) {
            const sidebar = document.getElementById("sidebar");
            const hamburger = document.querySelector("button[onclick='toggleSidebar()']");

            if (!sidebar.contains(event.target) && !hamburger.contains(event.target) && window.innerWidth < 768) {
                sidebar.classList.add("-translate-x-full");
            }
        });
    </script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('updateUrl', (path) => {
                const url = new URL(window.location);
                url.searchParams.set('path', JSON.stringify(path));
                window.history.pushState({}, '', url);
            });

            window.addEventListener('popstate', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const path = JSON.parse(urlParams.get('path') || '[]');

                // Emit event ke Livewire untuk memperbarui path
                Livewire.emit('setPath', path);
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('closeMenu', () => {
                // Menutup menu ketika ada klik di luar
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.context-menu')) {
                        Livewire.dispatch('menu-closed');
                    }
                });
            });
        });
    </script>

</body>

</html>