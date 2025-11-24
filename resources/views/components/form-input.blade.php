<div class="mb-4">
  @if(isset($label))
  <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">{{ $label }}</label>
  @endif
  <input {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-primary']) }} />
  @error($attributes->get('name'))
  <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
  @enderror
</div>
