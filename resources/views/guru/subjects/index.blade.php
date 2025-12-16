@extends('layouts.app')

@section('title', 'Mata Pelajaran - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 p-6">
                    @if($subjects->count() > 0)
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($subjects as $subject)
                            <div class="border dark:border-gray-600 rounded-lg p-6 hover:shadow-md transition duration-200">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                                    {{ $subject->name }}
                                </h3>

                                @if($subject->description)
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                                        {{ Str::limit($subject->description, 100) }}
                                    </p>
                                @endif

                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Kelas yang diajar:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($subject->schedules as $schedule)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                            {{ $schedule->class->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>

                                <a href="{{ route('guru.subjects.show', $subject) }}"
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center px-4 py-2 rounded font-medium transition duration-200 block">
                                    Lihat Detail
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tidak ada mata pelajaran</h3>
                            <p class="text-gray-500 dark:text-gray-400">Anda belum mengajar mata pelajaran apapun.</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
