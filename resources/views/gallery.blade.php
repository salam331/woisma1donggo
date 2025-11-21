<x-publik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Galeri') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-4">Galeri SMAN 1 Donggo</h1>
                    <p class="text-lg mb-6">Koleksi foto kegiatan dan fasilitas sekolah kami.</p>

                    @if($galleries->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($galleries as $gallery)
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow" onclick="window.location.href='{{ route('gallery.show', $gallery->id) }}'">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-48 object-cover">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">{{ $gallery->title }}</h3>
                                        @if($gallery->description)
                                            <p class="text-gray-600 text-sm mb-2">{{ $gallery->description }}</p>
                                        @endif
                                        @if($gallery->category)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ $gallery->category }}</span>
                                        @endif
                                        @if($gallery->event_date)
                                            <p class="text-gray-500 text-xs mt-2">{{ $gallery->event_date->format('d M Y') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada galeri yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-publik-layout>
