@props(['active'])

@php
$classes = ($active ?? false)
    ? 'relative inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-600 
       after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full 
       after:bg-indigo-600 after:rounded-full'
    : 'relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 
       hover:text-gray-900 
       after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 
       after:bg-indigo-600 after:transition-all after:duration-200 
       hover:after:w-full after:rounded-full';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
