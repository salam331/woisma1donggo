@extends('layouts.app')

@section('title', 'Buat Jadwal Baru')

@section('content')
    {{-- Card --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                Buat Jadwal Baru
            </h2>
            <a href="{{ route('admin.schedules.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded">
                Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Class --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Kelas
                    </label>
                    <select name="class_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Subject --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Mata Pelajaran
                    </label>
                    <select name="subject_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teacher --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Guru
                    </label>
                    <select name="teacher_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Pilih Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Day --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Hari
                    </label>
                    <select name="day" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">Pilih Hari</option>
                        <option value="monday" {{ old('day') == 'monday' ? 'selected' : '' }}>Senin</option>
                        <option value="tuesday" {{ old('day') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                        <option value="wednesday" {{ old('day') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                        <option value="thursday" {{ old('day') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                        <option value="friday" {{ old('day') == 'friday' ? 'selected' : '' }}>Jumat</option>
                        <option value="saturday" {{ old('day') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                        <option value="sunday" {{ old('day') == 'sunday' ? 'selected' : '' }}>Minggu</option>
                    </select>
                    @error('day')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Start Time --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Jam Mulai
                    </label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- End Time --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Jam Selesai
                    </label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                               focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-100">
                    @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Submit --}}
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold px-4 py-2 rounded">
                    Simpan Jadwal
                </button>
            </div>

        </form>
    </div>

@endsection