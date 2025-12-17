@extends('layouts.app')

@section('title', 'Edit Nilai ' . $exam->title . ' - ' . $subject->name . ' - Kelas ' . $class->name . ' - Guru Dashboard')

@section('content')
<div class="flex h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto">
                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('guru.grades.exam', [$class->id, $subject->id, $exam->id]) }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Detail Nilai
                    </a>
                </div>

                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Edit Nilai {{ $exam->title }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $subject->name }} - Kelas {{ $class->name }} | {{ $exam->exam_date->format('d M Y') }}
                    </p>
                </div>

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

                <!-- Edit Form -->
                <form action="{{ route('guru.grades.update-exam', [$class->id, $subject->id, $exam->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Input/Edit Nilai Siswa
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Masukkan nilai untuk setiap siswa (0-100)
                            </p>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            No
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nama Siswa
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            NIS
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nilai
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Grade
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($students as $index => $student)
                                    @php
                                        $grade = $grades->get($student->id);
                                        $score = $grade ? $grade->score : null;
                                        $letterGrade = $score ? getLetterGrade($score) : '-';
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-300">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $student->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $student->nis ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            <input type="number" 
                                                   name="grades[{{ $student->id }}][score]" 
                                                   value="{{ $score ?? '' }}" 
                                                   min="0" 
                                                   max="100" 
                                                   step="0.01"
                                                   class="w-20 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                   placeholder="100">
                                            <input type="hidden" 
                                                   name="grades[{{ $student->id }}][student_id]" 
                                                   value="{{ $student->id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span id="grade-{{ $student->id }}" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $score >= 90 ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 
                                                   ($score >= 80 ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' : 
                                                   ($score >= 70 ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' : 
                                                   ($score >= 60 ? 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100' : 
                                                   'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'))) }}">
                                                {{ $letterGrade }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Nilai
                            </button>
                            <a href="{{ route('guru.grades.exam', [$class->id, $subject->id, $exam->id]) }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                        
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-info-circle mr-1"></i>
                            Kosongkan nilai jika siswa tidak mengikuti ujian
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-update grade display when score changes
    const scoreInputs = document.querySelectorAll('input[name*="[score]"]');
    
    scoreInputs.forEach(input => {
        input.addEventListener('input', function() {
            const score = parseFloat(this.value);
            const studentId = this.name.match(/grades\[(\d+)\]/)[1];
            const gradeElement = document.getElementById('grade-' + studentId);
            
            if (isNaN(score)) {
                gradeElement.textContent = '-';
                gradeElement.className = 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
            } else {
                const letterGrade = getLetterGrade(score);
                gradeElement.textContent = letterGrade;
                
                let className = 'inline-flex px-2 py-1 text-xs font-semibold rounded-full ';
                if (score >= 90) {
                    className += 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100';
                } else if (score >= 80) {
                    className += 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100';
                } else if (score >= 70) {
                    className += 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100';
                } else if (score >= 60) {
                    className += 'bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100';
                } else {
                    className += 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100';
                }
                
                gradeElement.className = className;
            }
        });
    });
});

function getLetterGrade(score) {
    if (score >= 90) return 'A';
    if (score >= 80) return 'B';
    if (score >= 70) return 'C';
    if (score >= 60) return 'D';
    return 'E';
}
</script>

@php
function getLetterGrade($score) {
    if ($score >= 90) return 'A';
    if ($score >= 80) return 'B';
    if ($score >= 70) return 'C';
    if ($score >= 60) return 'D';
    return 'E';
}
@endphp
@endsection

