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
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <link href="{{ asset('/build/assets/app.css') }}" rel="stylesheet">
    <script src="{{ asset('/build/assets/app.js') }}"></script>
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    


</head>

<body class="font-urbanist antialiased bg-secondary ">
    <div class="min-h-screen bg-secondary dark:bg-neutralDark text-neutralDark dark:text-secondary">
        <livewire:layout.navigation />
        @livewireScripts

        <!-- Page Heading -->
        @if (isset($header))
        <header class=" bg-secondary dark:bg-neutralDark ">
            <div class=" py-24 px-10 sm:px-6 lg:px-8 text-2xl  justify-center items-center text-center mx-auto ">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <x-footers/>
</body>

</html>