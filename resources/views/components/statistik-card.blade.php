@props([
    'title' => 'Total Foto', 
    'count' => 0, 
    'span' => 3, 
    'bg' => 'bg-primary', 
    'text' => 'text-secondary',
    'iconBig' => '', // Ikon besar di belakang
])

<div class="relative col-span-3 sm:col-span-{{ $span }} {{ $bg }} {{ $text }} rounded-3xl p-8 h-full flex flex-col justify-between overflow-hidden">
    <!-- Ikon besar di belakang -->
    <div class="absolute right-20  -bottom-12 text-white opacity-20 text-9xl">
        <x-icon :name="$iconBig" class="size-48" />
    </div>

    <div>
        <div class="flex justify-between">
            <div>
                <h2 class="text-3xl font-medium">{{ $title }}</h2>
                <p>Rekap tahun {{ now()->year }}</p>
            </div>
            <div class="border rounded-full p-2 items-center flex">
                {{ $slot }} <!-- Slot untuk ikon kecil -->
            </div>
        </div>
    </div>
    <h1 class="text-7xl font-medium">{{ number_format($count) }}</h1>
</div>
