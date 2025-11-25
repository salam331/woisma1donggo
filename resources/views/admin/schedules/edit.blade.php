@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')

    <!-- FORM CONTAINER -->
    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
        <!-- HEADER -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Edit Jadwal
            </h2>

            <div class="flex space-x-2">
                <a href="{{ route('admin.schedules.show', $schedule) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Lihat
                </a>

                <a href="{{ route('admin.schedules.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Class -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kelas</label>
                    <select name="class_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Pilih Kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $schedule->class_id) == $class->id ? 'selected' : '' }}> {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mata Pelajaran</label>
                    <select name="subject_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teacher -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Guru</label>
                    <select name="teacher_id"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Pilih Guru</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id', $schedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Day -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hari</label>
                    <select name="day"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Pilih Hari</option>
                        <option value="monday" {{ old('day', $schedule->day) == 'monday' ? 'selected' : '' }}>Senin</option>
                        <option value="tuesday" {{ old('day', $schedule->day) == 'tuesday' ? 'selected' : '' }}>Selasa
                        </option>
                        <option value="wednesday" {{ old('day', $schedule->day) == 'wednesday' ? 'selected' : '' }}>Rabu
                        </option>
                        <option value="thursday" {{ old('day', $schedule->day) == 'thursday' ? 'selected' : '' }}>Kamis
                        </option>
                        <option value="friday" {{ old('day', $schedule->day) == 'friday' ? 'selected' : '' }}>Jumat</option>
                        <option value="saturday" {{ old('day', $schedule->day) == 'saturday' ? 'selected' : '' }}>Sabtu
                        </option>
                        <option value="sunday" {{ old('day', $schedule->day) == 'sunday' ? 'selected' : '' }}>Minggu</option>
                    </select>
                    @error('day')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Mulai</label>
                    <input type="time" name="start_time"
                        value="{{ old('start_time', $schedule->start_time->format('H:i')) }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jam Selesai</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $schedule->end_time->format('H:i')) }}"
                        class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                    Update Jadwal
                </button>
            </div>

        </form>

    </div>

@endsection