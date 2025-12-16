@extends('layouts.app')

@section('title', 'Pengumuman - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    @if($announcements->count() > 0)
                        <div class="space-y-4">
                            @foreach($announcements as $announcement)
                            <div class="border dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition duration-200">

                                        <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                            {{ $announcement->title }}
                                        </h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $announcement->created_at->format('d M Y H:i') }}</span>
                                            @if($announcement->target)
                                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Target: {{ ucfirst($announcement->target) }}</span>
                                            @endif
                                            @if($announcement->is_active)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Tidak Aktif</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('guru.announcements.show', $announcement) }}"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm font-medium transition duration-200">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>

                                <div class="text-gray-700 dark:text-gray-300 line-clamp-3">
                                    {!! Str::limit(strip_tags($announcement->content), 200) !!}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $announcements->links() }}
                        </div>

                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-bullhorn text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada pengumuman</h3>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada pengumuman yang dapat ditampilkan saat ini.</p>
                            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm">Admin akan membuat pengumuman jika diperlukan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
