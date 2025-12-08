@extends('layouts.app')

@section('title', 'Manajemen Kelas')

@section('content')

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input id="title" type="text" name="title" value="{{ old('title', $announcement->title) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
                                    <input id="content" type="hidden" name="content" value="{{ old('content', $announcement->content) }}">
                                    <trix-editor input="content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></trix-editor>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Publish Date -->
                                <div>
                                    <label for="publish_date" class="block text-sm font-medium text-gray-700">Tanggal Publikasi</label>
                                    <input id="publish_date" type="date" name="publish_date" value="{{ old('publish_date', $announcement->publish_date->format('Y-m-d')) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('publish_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Target -->
                                <div>
                                    <label for="target" class="block text-sm font-medium text-gray-700">Target</label>
                                    <select id="target" name="target" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="semua" {{ old('target', $announcement->target) == 'semua' ? 'selected' : '' }}>Semua</option>
                                        <option value="guru" {{ old('target', $announcement->target) == 'guru' ? 'selected' : '' }}>Guru</option>
                                        <option value="siswa" {{ old('target', $announcement->target) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        <option value="orang_tua" {{ old('target', $announcement->target) == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
                                        <option value="publik" {{ old('target', $announcement->target) == 'publik' ? 'selected' : '' }}>Publik</option>
                                    </select>
                                    @error('target')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Is Active -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-2">
                                        <input type="hidden" name="is_active" value="0">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                        </label>
                                    </div>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar (Opsional)</label>
                                    @if($announcement->image)
                                        <div class="mt-2 mb-4">
                                            <p class="text-sm text-gray-600">Gambar Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $announcement->image) }}" alt="Current Image" class="w-32 h-32 object-cover rounded border">
                                        </div>
                                    @endif
                                    <input id="image" type="file" name="image" accept="image/*"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Pengumuman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
