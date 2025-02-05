@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-200 text-start text-base font-medium text-white bg-yellow-600 focus:outline-none focus:text-white focus:bg-yellow-600 focus:border-yellow-200 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-yellow-100 hover:text-white hover:bg-yellow-600 hover:border-yellow-300 focus:outline-none focus:text-white focus:bg-yellow-600 focus:border-yellow-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
