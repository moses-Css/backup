@props(['value'])

<h1 {{ $attributes->merge(['class' => 'mt-2 text-sm text-neutralGray md:text-lg']) }}>
    {{ $value ?? $slot }}
</h1>