<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">
                Edit Orang Tua: {{ $parent->name }}
            </h2>

            <a href="{{ route('admin.parents.index') }}">
                <button
                    class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                    Kembali
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
                <div class="p-8">

                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Form Edit Orang Tua</h3>

                    <form method="POST" action="{{ route('admin.parents.update', $parent) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <!-- Left Column -->
                            <div class="space-y-5">

                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $parent->name) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $parent->email) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone', $parent->phone) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Relationship -->
                                <div>
                                    <label for="relationship" class="block text-sm font-medium text-gray-700">Hubungan dengan Siswa</label>
                                    <select id="relationship" name="relationship" required
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="father" {{ old('relationship', $parent->relationship) == 'father' ? 'selected' : '' }}>Ayah</option>
                                        <option value="mother" {{ old('relationship', $parent->relationship) == 'mother' ? 'selected' : '' }}>Ibu</option>
                                        <option value="guardian" {{ old('relationship', $parent->relationship) == 'guardian' ? 'selected' : '' }}>Wali</option>
                                    </select>
                                    @error('relationship')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <!-- Right Column -->
                            <div class="space-y-5">

                                <!-- Current Photo -->
                                @if($parent->photo)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Foto Saat Ini</label>
                                    <img src="{{ asset('storage/' . $parent->photo) }}" alt="Current Photo"
                                         class="mt-2 h-24 w-24 rounded-full object-cover shadow">
                                </div>
                                @endif

                                <!-- Upload Photo -->
                                <div>
                                    <label for="photo" class="block text-sm font-medium text-gray-700">
                                        {{ $parent->photo ? 'Ganti Foto' : 'Foto' }}
                                    </label>
                                    <input id="photo" type="file" name="photo" accept="image/*"
                                           class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    @error('photo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, GIF (max 2MB).</p>
                                </div>

                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mt-8">
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="address" name="address" rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $parent->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                                Update Orang Tua
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
