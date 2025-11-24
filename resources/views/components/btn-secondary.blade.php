<button {{ $attributes->merge(['class' => 'bg-secondary text-white rounded-xl px-4 py-2 shadow-md hover:bg-secondary-dark focus:outline-none focus:ring-2 focus:ring-secondary']) }}>
  {{ $slot }}
</button>
