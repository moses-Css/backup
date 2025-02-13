@php
    $iconSvg = $icons[$name] ?? '';
    // Tambahkan class ke dalam SVG jika ada
    if ($class && $iconSvg) {
        $iconSvg = str_replace('<svg ', '<svg class="' . e($class) . '" ', $iconSvg);
    }
@endphp

{!! $iconSvg !!}
