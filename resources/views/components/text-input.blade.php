@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-2.5 
             text-gray-900 shadow-inner outline-none
             focus:border-blue-400 focus:ring-4 focus:ring-blue-100
             transition-all duration-200 ease-out'
    ]) }}
>
