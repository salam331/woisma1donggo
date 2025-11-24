<div {{ $attributes->merge(['class' => 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden']) }}>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-lg w-full p-6">
    {{ $slot }}
    <div class="mt-4 flex justify-end">
      <button type="button" class="btn-secondary" onclick="this.closest('div[role=dialog]').parentElement.style.display='none'">Tutup</button>
    </div>
  </div>
</div>
