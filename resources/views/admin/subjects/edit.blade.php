@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran — ' . $subject->name)

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- CARD -->
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                    Edit Mata Pelajaran: {{ $subject->name }}
                </h2>
                <a href="{{ route('admin.subjects.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>

            <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Left Column -->
                    <div class="space-y-4">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nama Mata Pelajaran
                            </label>
                            <input id="name" name="name" type="text" value="{{ old('name', $subject->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kode Mata Pelajaran
                            </label>
                            <input id="code" name="code" type="text" value="{{ old('code', $subject->code) }}" required
                                placeholder="Contoh: MTK, IPA, IPS"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher -->
                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Guru Pengajar (Opsional)
                            </label>
                            <select id="teacher_id" name="teacher_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Guru Pengajar</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} - {{ $teacher->nip }}
                                    </option>
                                @endforeach
                            </select>
                            @error('teacher_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Deskripsi (Opsional)
                            </label>
                            <textarea id="description" name="description" rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Deskripsikan tentang mata pelajaran ini...">{{ old('description', $subject->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

                <!-- Submit -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Mata Pelajaran
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection