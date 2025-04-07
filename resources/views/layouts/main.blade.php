<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="darkMode ? 'dark' : ''">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') BKKBN.Galeri</title>
    @livewireStyles


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- <link href="{{ secure_asset('/build/assets/app.css') }}" rel="stylesheet">
    <script src="{{ secure_asset('/build/assets/app.js') }}"></script> -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/split-type"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>

<body class="font-urbanist text-neutraldark dark:text-gray-100 bg-secondary dark:bg-neutralDark antialiased">

    <livewire:layout.navigation />
    <div class="w-full  bg-secondary dark:bg-neutralDark  overflow-hidden sm:rounded-lg  ">
        @yield('content')
    </div>
    @livewireScripts

    <script>
        AOS.init();

        let text = new SplitType("#x-head-text");
        let characters = document.querySelectorAll('.char');

        // Sembunyikan teks ke bawah dulu
        characters.forEach(char => char.style.transform = "translateY(100%)");

        // Animasi dengan GSAP
        gsap.to('.char', {
            y: 0,
            duration: 0.5,
            stagger: 0.05,
            ease: "power3.out"
        });
    </script>
</body>


<x-footers />


</html>
