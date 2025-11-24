@extends('layouts.guest')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Pengumuman') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">Pengumuman Terbaru</h1>
                <p class="text-lg mb-6">Informasi penting dari sekolah untuk siswa, guru, dan orang tua.</p>

                <div class="space-y-6">
                    @forelse($announcements as $announcement)
                        <div class="border-l-4 border-blue-500 pl-4 cursor-pointer hover:bg-gray-50 p-4 rounded"
                             onclick="openModal('modal-{{ $announcement->id }}')">
                            @if($announcement->image)
                                <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                                     class="w-full h-48 object-cover mb-4 rounded">
                            @endif
                            <h3 class="text-xl font-semibold text-blue-800">{{ $announcement->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                Diterbitkan pada: {{ $announcement->publish_date->format('d F Y') }}
                            </p>

                            <div class="text-gray-700 prose max-w-none">{!! $announcement->content !!}</div>

                            <p class="text-sm text-blue-600 mt-2">Klik untuk baca selengkapnya</p>
                        </div>
                    @empty
                        <p class="text-gray-500">Tidak ada pengumuman saat ini.</p>
                    @endforelse
                </div>

                <!-- Modals for each announcement -->
                @foreach($announcements as $announcement)
                    <div id="modal-{{ $announcement->id }}"
                         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                            <div class="mt-3">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $announcement->title }}</h3>
                                    <button onclick="closeModal('modal-{{ $announcement->id }}')"
                                            class="text-gray-400 hover:text-gray-600">
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

                                <p class="text-sm text-gray-600 mb-4">
                                    Diterbitkan pada: {{ $announcement->publish_date->format('d F Y') }}
                                </p>

                                <div class="text-gray-700 prose max-w-none">{!! $announcement->content !!}</div>
                            </div>
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
        </div>
    </div>
</div>
@endsection
