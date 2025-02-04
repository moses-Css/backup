<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" :class="darkMode ? 'dark' : ''">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BKKBN.Galeri') }}</title>

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
        <button @click="darkMode = !darkMode"
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
        </button>

        @yield('content')
    </div>
</body>
<footer class="bg-gray-900 text-white text-center py-12">
        <p>&copy; 2025 YourCompany. All rights reserved.</p>
    </footer>


</html>