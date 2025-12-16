@extends('layouts.app')

@section('title', $announcement->title . ' - Pengumuman')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('guru.announcements.index') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Daftar Pengumuman
                    </a>
                </div>

                <!-- Announcement Content -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="border-b dark:border-gray-700 p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ $announcement->title }}
                                </h1>
                                
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $announcement->created_at->format('d M Y H:i') }}
                                    </div>
                                    
                                    @if($announcement->target)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                                Target: {{ ucfirst($announcement->target) }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($announcement->is_active)
                                        <div class="flex items-center">
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                                Aktif
                                            </span>
                                        </div>
                                    @else
                                        <div class="flex items-center">
                                            <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                                Tidak Aktif
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>

                    <!-- Footer -->
                    @if($announcement->publish_date)
                    <div class="border-t dark:border-gray-700 p-6 bg-gray-50 dark:bg-gray-750">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Published: {{ \Carbon\Carbon::parse($announcement->publish_date)->format('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

