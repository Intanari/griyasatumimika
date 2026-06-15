@props([
    'variant' => 'nav',
])

@php
    $class = match ($variant) {
        'footer' => 'yayasan-logo yayasan-logo--footer',
        'sidebar' => 'yayasan-logo yayasan-logo--sidebar',
        'auth' => 'yayasan-logo yayasan-logo--auth',
        default => 'yayasan-logo yayasan-logo--nav',
    };
@endphp

<img
    src="{{ asset('images/logo-yayasan.png') }}"
    alt="Yayasan Griya Satu Mimika"
    {{ $attributes->merge(['class' => $class]) }}
>
