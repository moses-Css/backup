@props([
    'icon',
    'iconClass' => '', // Hapus !fill-neutralDark agar bisa dikontrol
    'route'
])

@php
    $isActive = request()->routeIs($route);
    $activeClass = $isActive ? 'text-primary bg-primaryLight rounded-md font-semibold' : 'text-neutralGray';
    $iconColor = $isActive ? 'fill-primary' : 'fill-neutralGray';
@endphp

<a {{ $attributes->merge([
    'class' => "group flex items-center gap-3 rounded-md cursor-pointer p-2 $activeClass",
    'href' => $route,
]) }} x-data>
    <x-icon :name="$icon" :class="'transition ' . $iconClass . ' ' . $iconColor . (!$isActive ? ' group-hover:fill-neutralDark' : '')" />
    <span class="menu-label text-base transition {{ !$isActive ? 'group-hover:text-neutralDark' : '' }}">{{ $slot }}</span> </a>