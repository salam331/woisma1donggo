<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Galeri
            </h2>
            <a href="{{ route('admin.galleries.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.galleries.update', $gallery) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input id="title" type="text" name="title" value="{{ old('title', $gallery->title) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea id="description" name="description" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $gallery->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori (Opsional)</label>
                                    <input id="category" type="text" name="category" value="{{ old('category', $gallery->category) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Event Date -->
                                <div>
                                    <label for="event_date" class="block text-sm font-medium text-gray-700">Tanggal Event (Opsional)</label>
                                    <input id="event_date" type="date" name="event_date" value="{{ old('event_date', $gallery->event_date ? $gallery->event_date->format('Y-m-d') : '') }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('event_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Image -->
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Gambar (Opsional)</label>
                                    @if($gallery->image_path)
                                        <div class="mt-2 mb-4">
                                            <p class="text-sm text-gray-600">Gambar Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Current Image" class="w-32 h-32 object-cover rounded border">
                                        </div>
                                    @endif
                                    <input id="image" type="file" name="image" accept="image/*"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah gambar.</p>
                                </div>

                                <!-- Is Active -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-2">
                                        <input type="hidden" name="is_active" value="0">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                        </label>
                                    </div>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Images -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Gambar Tambahan</label>
                            <div id="additional-images-container">
                                @if($gallery->additional_images)
                                    @foreach($gallery->additional_images as $index => $additional)
                                        <div class="additional-image-item mb-4 p-4 border rounded bg-gray-50">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Gambar Tambahan</label>
                                                    <input type="file" name="additional_images[{{ $index }}][image]" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                    <input type="hidden" name="additional_images[{{ $index }}][existing_image_path]" value="{{ $additional['image_path'] }}">
                                                    <input type="hidden" name="additional_images[{{ $index }}][existing_description]" value="{{ $additional['description'] ?? '' }}">
                                                    {{-- @if(isset($additional['image_path']))
                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $additional['image_path']) }}" alt="Additional Image" class="w-32 h-32 object-cover rounded border">
                                                        </div>
                                                    @endif --}}
                                                    @if(isset($additional['image_path']))
                                                        <input type="hidden" 
                                                            name="additional_images[{{ $index }}][existing_image_path]" 
                                                            value="{{ $additional['image_path'] }}">

                                                        <div class="mt-2">
                                                            <img src="{{ asset('storage/' . $additional['image_path']) }}" 
                                                                class="w-32 h-32 object-cover rounded border">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Deskripsi Gambar</label>
                                                    <textarea name="additional_images[{{ $index }}][description]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ $additional['description'] ?? '' }}</textarea>
                                                </div>
                                            </div>
                                            <button type="button" class="remove-additional-image mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" id="add-additional-image" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                + Tambah Gambar Tambahan
                            </button>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Galeri
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let additionalImageIndex = {{ $gallery->additional_images ? count($gallery->additional_images) : 0 }};

        document.getElementById('add-additional-image').addEventListener('click', function() {
            const container = document.getElementById('additional-images-container');
            const div = document.createElement('div');
            div.className = 'additional-image-item mb-4 p-4 border rounded bg-gray-50';
            div.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gambar Tambahan</label>
                        <input type="file" name="additional_images[${additionalImageIndex}][image]" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Gambar</label>
                        <textarea name="additional_images[${additionalImageIndex}][description]" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <button type="button" class="remove-additional-image mt-2 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
            `;
            container.appendChild(div);
            additionalImageIndex++;

            // Add remove functionality
            div.querySelector('.remove-additional-image').addEventListener('click', function() {
                container.removeChild(div);
            });
        });

        // Add remove functionality to existing items
        document.querySelectorAll('.remove-additional-image').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.additional-image-item').remove();
            });
        });
    </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
