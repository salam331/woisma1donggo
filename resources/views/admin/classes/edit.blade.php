@extends('layouts.app')

@section('title', 'Edit Kelas — ' . $class->name)

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- CARD -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                    Edit Kelas: {{ $class->name }}
                </h2>
                <a href="{{ route('admin.classes.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    Kembali
                </a>
            </div>
            <form method="POST" action="{{ route('admin.classes.update', $class) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT COLUMN -->
                    <div class="space-y-4">

                        <!-- Name -->
                        <div>
                            <label for="name" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Kelas
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name', $class->name) }}"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
                                required>
                            @error('name')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grade Level -->
                        <div>
                            <label for="grade_level" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Tingkat Kelas
                            </label>
                            <select id="grade_level" name="grade_level"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
                                required>
                                <option value="">Pilih Tingkat Kelas</option>
                                @foreach(range(1, 12) as $num)
                                    <option value="Kelas {{ $num }}" {{ old('grade_level', $class->grade_level) == "Kelas $num" ? 'selected' : '' }}>
                                        Kelas {{ $num }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_level')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher -->
                        <div>
                            <label for="teacher_id" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Wali Kelas (Opsional)
                            </label>
                            <select id="teacher_id" name="teacher_id"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                                <option value="">Pilih Wali Kelas</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $class->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} - {{ $teacher->nip }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="space-y-4">
                        <div>
                            <label for="description" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi (Opsional)
                            </label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">{{ old('description', $class->description) }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                        Update Kelas
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection