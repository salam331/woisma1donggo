@extends('layouts.guest')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Pengumuman') }}
</h2>
@endsection

@section('content')
<section class="bg-white dark:bg-gray-900 py-12">
    <div class="container px-6 mx-auto">
        <div class="flex items-center justify-center mb-6">
            <h1 class="text-2xl font-bold text-primary lg:text-3xl dark:text-white">Pengumuman Terbaru</h1>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($announcements as $announcement)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                 onclick="openModal('modal-{{ $announcement->id }}')">
                
                @if($announcement->image)
                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                         class="object-cover w-full h-48 lg:h-56">
                @endif

                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $announcement->title }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        {{ $announcement->publish_date->format('d F Y') }}
                    </p>
                    <div class="text-gray-700 dark:text-gray-300 prose max-w-none mb-4 line-clamp-3">
                        {!! $announcement->content !!}
                    </div>
                    <p class="text-blue-500 underline text-sm">Klik untuk baca selengkapnya</p>
                </div>
            </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Tidak ada pengumuman saat ini.</p>
            @endforelse
        </div>

        <!-- Modals for each announcement -->
        @foreach($announcements as $announcement)
        <div id="modal-{{ $announcement->id }}" 
             class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $announcement->title }}</h3>
                    <button onclick="closeModal('modal-{{ $announcement->id }}')" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if($announcement->image)
                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                         class="w-full h-64 object-cover mb-4 rounded">
                @endif

                <p class="text-sm text-gray-600 mb-4">Diterbitkan pada: {{ $announcement->publish_date->format('d F Y') }}</p>

                <div class="text-gray-700 dark:text-gray-300 prose max-w-none">{!! $announcement->content !!}</div>
            </div>
        </div>
        @endforeach

        <script>
            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            // Close modal when clicking outside the modal box
            @foreach($announcements as $announcement)
            document.getElementById('modal-{{ $announcement->id }}').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal('modal-{{ $announcement->id }}');
                }
            });
            @endforeach
        </script>
    </div>
</section>
@endsection
