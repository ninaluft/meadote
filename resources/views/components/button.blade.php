<!-- resources/views/vendor/jetstream/components/button.blade.php -->

@props([
    'icon' => null, // Ícone opcional
    'color' => 'gray', // Cor do botão, com padrão 'gray'
    'size' => 'md', // Tamanho do botão: 'sm', 'md', 'lg'
    'href' => null, // Link opcional para transformar o botão em um link
    'ariaLabel' => '' // Acessibilidade
])

@php
    // Classes para cores
    $colorClasses = match($color) {
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'red' => 'bg-red-500 hover:bg-red-600 text-white',
        'blue' => 'bg-blue-500 hover:bg-blue-600 text-white',
        'green' => 'bg-green-500 hover:bg-green-600 text-white',
        default => 'bg-gray-800 hover:bg-gray-700 text-white',
    };

    // Classes para o tamanho
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-md',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-md',
    };
@endphp

@if($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md   text-white  focus:outline-none   disabled:opacity-50 "]) }}
        aria-label="{{ $ariaLabel }}">
        @if ($icon)
            <i class="{{ $icon }} mr-2" aria-hidden="true"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md   text-white  focus:outline-none   disabled:opacity-50 "]) }}
        aria-label="{{ $ariaLabel }}">
        @if ($icon)
            <i class="{{ $icon }} mr-2" aria-hidden="true"></i>
        @endif
        {{ $slot }}
    </button>
@endif
