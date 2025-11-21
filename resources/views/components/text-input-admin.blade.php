@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'w-full rounded-lg border border-gray-300 bg-white px-3 py-2
             text-gray-800 shadow-sm outline-none
             focus:border-blue-500 focus:ring-2 focus:ring-blue-300 transition'
    ]) }}
>
