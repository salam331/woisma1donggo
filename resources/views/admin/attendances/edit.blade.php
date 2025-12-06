@extends('layouts.app')

@section('title', 'Edit Kehadiran')

@section('content')

    <div class="p-6">
        <div class="max-w-4xl mx-auto">



            <!-- CARD -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
                <!-- HEADER -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Edit Kehadiran: {{ $attendance->student->name }}
                    </h2>

                    <a href="{{ route('admin.attendances.student-history', ['studentId' => $attendance->student->id, 'subjectId' => $attendance->schedule->subject->id]) }}"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
                <form method="POST" action="{{ route('admin.attendances.update', $attendance) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- LEFT COLUMN -->
                        <div class="space-y-4">

                            <!-- Student -->
                            <div>
                                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Siswa
                                </label>
                                <select id="student_id" name="student_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                           focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id', $attendance->student_id) == $student->id ? 'selected' : '' }}> {{ $student->name }} -
                                            {{ $student->nis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Schedule -->
                            <div>
                                <label for="schedule_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jadwal
                                </label>
                                <select id="schedule_id" name="schedule_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                           focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Jadwal</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}" {{ old('schedule_id', $attendance->schedule_id) == $schedule->id ? 'selected' : '' }}>
                                            {{ $schedule->subject->name ?? '-' }} - {{ $schedule->class->name ?? '-' }} -
                                            {{ $schedule->day }} {{ $schedule->start_time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('schedule_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Tanggal
                                </label>
                                <input id="date" type="date" name="date"
                                    value="{{ old('date', $attendance->date->format('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                          bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                          focus:ring-blue-500 focus:border-blue-500">
                                @error('date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="space-y-4">

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status Kehadiran
                                </label>
                                <select id="status" name="status" required class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                           focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Status</option>

                                    <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Hadir</option>
                                    <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Tidak Hadir</option>
                                    <option value="late" {{ old('status', $attendance->status) == 'late' ? 'selected' : '' }}>
                                        Terlambat</option>
                                    <option value="excused" {{ old('status', $attendance->status) == 'excused' ? 'selected' : '' }}>Izin</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Catatan (Opsional)
                                </label>
                                <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                             bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200
                                             focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes', $attendance->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <!-- Submit -->
                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Kehadiran
                        </button>
                    </div>

                </form>
            </div>
        </div>
@endsection