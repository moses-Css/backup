@props(['value'])

<h1 {{ $attributes->merge([ 'class' => 'text-xl xl:text-4xl 2xl:text-7xl font-medium dark:text-secondary ']) }}>
    {{$value ?? $slot}}
</h1>