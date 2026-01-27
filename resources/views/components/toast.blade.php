@if(session()->has('toast'))
@php
    $toast = session('toast');
@endphp

<div
    x-data="{ show: false }"
    x-init="
        setTimeout(() => show = true, 50);
        setTimeout(() => show = false, 3000);
    "
    x-show="show"
    x-transition:enter="transform transition ease-[cubic-bezier(0.16,1,0.3,1)] duration-500"
    x-transition:enter-start="opacity-0 translate-y-[-12px] scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transform transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-[-8px] scale-95"
    class="fixed top-4 right-4 z-[9999] max-w-sm px-4 py-3 rounded-lg shadow-xl text-white pointer-events-auto
        @if($toast['type'] === 'success') bg-green-600
        @elseif($toast['type'] === 'error') bg-red-600
        @elseif($toast['type'] === 'warning') bg-yellow-500
        @else bg-blue-600 @endif
    "
>
    {{ $toast['message'] }}
</div>
@endif
