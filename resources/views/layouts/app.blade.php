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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    

</head>

<body class="font-urbanist antialiased">
    <div class="min-h-screen bg-secondary dark:bg-neutralDark text-neutralDark dark:text-secondary">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
        <header class=" bg-secondary dark:bg-neutralDark ">
            <div class=" py-12 pb-24 px-10 sm:px-6 lg:px-8 text-2xl  justify-center items-center text-center mx-auto ">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>