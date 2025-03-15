@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => ' w-full p-4 rounded-full border border-neutralGray2']) }}>
