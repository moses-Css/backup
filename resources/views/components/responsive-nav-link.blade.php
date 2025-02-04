@props(['active','extraClass' => ''])

@php
$classes = ($active ?? false)
            ? ' block w-full ps-3 pe-4 py-2   text-center text-4xl text-neutraldark dark:text-secondary  dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out'
            : ' block w-full ps-3 pe-4 py-2 text-center text-4xl  text-neutraldark dark:text-secondary hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';

            $classes .= '' . $extraClass;
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
