<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="darkMode ? 'dark' : ''">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') BKKBN.Galeri</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>


<!-- BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY
BODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODYBODY -->


<body class="font-urbanist text-neutraldark dark:text-gray-100 bg-secondary dark:bg-neutralDark antialiased">
    <livewire:layout.navigation />

    <div class="w-full  bg-secondary dark:bg-neutralDark  overflow-hidden sm:rounded-lg  ">
        <!-- Tombol Toggle Dark Mode -->
        

        @yield('content')
    </div>
</body>
<footer class="bg-gray-900 text-white text-center py-12">
        <p>&copy; 2025 YourCompany. All rights reserved.</p>
    </footer>


</html>