@props([
    'height' => 44,
    'forPdf' => false,
])

<img
    src="{{ $forPdf ? public_path('images/logo-yayasan.png') : asset('images/logo-yayasan.png') }}"
    alt="Yayasan Griya Satu Mimika"
    style="height: {{ (int) $height }}px; width: auto; object-fit: contain; display: block;"
    {{ $attributes }}
>
