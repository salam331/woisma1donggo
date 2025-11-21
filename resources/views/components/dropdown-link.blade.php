<a {{ 
    $attributes->merge([
        'class' => 
            'block w-full px-4 py-2 text-sm text-gray-700 
            hover:bg-gray-100/80 hover:text-gray-900 
            rounded-lg transition duration-200 ease-out 
            focus:outline-none focus:bg-gray-100 focus:text-gray-900'
    ]) 
}}>
    {{ $slot }}
</a>
