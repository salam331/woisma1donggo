@extends('layouts.app')

@section('title', 'Nilai - Guru Dashboard')

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
                    @if($classes->count() > 0)
                        <div class="mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Pilih Kelas untuk Melihat Nilai</h2>
                        </div>
                        
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($classes as $class)
                            <div class="border dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition duration-200">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                            {{ $class->name }}
                                        </h3>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            Wali Kelas: {{ $class->teacher->name ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('guru.grades.class', $class->id) }}"
                                       class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-3 py-2 rounded text-sm font-medium transition duration-200">
                                        Lihat Nilai
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-graduation-cap text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada kelas yang diajar</h3>
                            <p class="text-gray-500 dark:text-gray-400">Anda belum mengajar di kelas manapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

