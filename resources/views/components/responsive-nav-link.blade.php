@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-4 pe-4 py-2 border-l-4 border-indigo-500 
       text-start text-base font-medium text-indigo-700 
       bg-indigo-50/50 backdrop-blur-sm 
       rounded-lg shadow-sm transition duration-300'
    : 'block w-full ps-4 pe-4 py-2 border-l-4 border-transparent 
       text-start text-base font-medium text-gray-600 
       rounded-lg 
       hover:bg-gray-100/60 hover:border-gray-300 
       hover:text-gray-900 backdrop-blur-sm
       transition duration-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
