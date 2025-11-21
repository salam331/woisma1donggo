<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">
                Tambah Orang Tua Baru
            </h2>
            
            <a href="{{ route('admin.parents.index') }}">
                <button
                    class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                       Kembali   
                </button>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-6">
            <div class="bg-white shadow-lg rounded-xl p-8 border border-gray-100">

                <h3 class="text-lg font-semibold text-gray-700 mb-6 border-b pb-3">
                    Formulir Data Orang Tua / Wali
                </h3>

                <form method="POST" action="{{ route('admin.parents.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Left Column -->
                        <div class="space-y-5">

                            {{-- Name --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" required
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            {{-- Phone --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Relationship --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Hubungan dengan Siswa</label>
                                <select name="relationship" required
                                        class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Hubungan</option>
                                    <option value="father" {{ old('relationship') == 'father' ? 'selected' : '' }}>Ayah</option>
                                    <option value="mother" {{ old('relationship') == 'mother' ? 'selected' : '' }}>Ibu</option>
                                    <option value="guardian" {{ old('relationship') == 'guardian' ? 'selected' : '' }}>Wali</option>
                                </select>
                                @error('relationship')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Right Column -->
                        <div class="space-y-5">

                            {{-- Photo --}}
                            <div>
                                <label class="text-sm font-medium text-gray-700">Foto</label>
                                <input type="file" name="photo" accept="image/*"
                                       class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('photo')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF — Max 2MB</p>
                            </div>

                        </div>

                    </div>

                    {{-- Address --}}
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-700">Alamat</label>
                        <textarea name="address" rows="3"
                                  class="mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end mt-8">
                        <button type="submit"
                                class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow transition">
                            Simpan Orang Tua
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-admin-layout>
