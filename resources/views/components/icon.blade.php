@php
    $iconSvg = $icons[$name] ?? '';
@endphp

<div class="{{ $class }}">
    {!! $iconSvg !!}
</div>