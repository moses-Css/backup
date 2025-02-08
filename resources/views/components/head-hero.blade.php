@props(['value'])

<h1 {{ $attributes->merge([ 'class' => 'text-5xl xl:text-7xl font-medium dark:text-secondary inline-block']) }}>
    {{$value ?? $slot}}
</h1>