@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-teal-600 text-lg font-medium leading-5 text-teal-700 focus:outline-none focus:border-teal-800 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-lg font-medium leading-5 text-teal-600 hover:text-teal-700 hover:border-teal-500 focus:outline-none focus:text-teal-700 focus:border-teal-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
