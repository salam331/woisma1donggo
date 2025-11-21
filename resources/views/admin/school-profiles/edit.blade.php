<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Profil Sekolah
            </h2>
            <a href="{{ route('admin.school-profiles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.school-profiles.update', $schoolProfile) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                                    <input id="name" type="text" name="name" value="{{ old('name', $schoolProfile->name) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <textarea id="address" name="address" rows="3"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('address', $schoolProfile->address) }}</textarea>
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone', $schoolProfile->phone) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $schoolProfile->email) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Website -->
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                                    <input id="content" type="hidden" name="website" value="{{ old('website', $schoolProfile->website) }}">
                                    <trix-editor input="content"></trix-editor>
                                    @error('website')
                                    <p>{{ $message }}</p>
                                    @enderror
                                    {{-- <input id="website" type="url" name="website" value="{{ old('website', $schoolProfile->website) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror --}}
                                </div>

                                <!-- Principal Name -->
                                <div>
                                    <label for="principal_name" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                                    <input id="principal_name" type="text" name="principal_name" value="{{ old('principal_name', $schoolProfile->principal_name) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('principal_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Logo -->
                                <div>
                                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo Sekolah</label>
                                    @if($schoolProfile->logo)
                                        <div class="mt-2 mb-2">
                                            <img src="{{ asset('storage/' . $schoolProfile->logo) }}" alt="Logo Sekolah" class="w-32 h-32 object-cover rounded-lg">
                                        </div>
                                    @endif
                                    <input id="logo" type="file" name="logo" accept="image/*"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</p>
                                    @error('logo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Sekolah</label>
                                    <textarea id="description" name="description" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $schoolProfile->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Vision -->
                                <div>
                                    <label for="vision" class="block text-sm font-medium text-gray-700">Visi</label>
                                    <textarea id="vision" name="vision" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('vision', $schoolProfile->vision) }}</textarea>
                                    @error('vision')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Mission -->
                                <div>
                                    <label for="mission" class="block text-sm font-medium text-gray-700">Misi</label>
                                    <textarea id="mission" name="mission" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('mission', $schoolProfile->mission) }}</textarea>
                                    @error('mission')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- History -->
                                <div>
                                    <label for="history" class="block text-sm font-medium text-gray-700">Sejarah Sekolah</label>
                                    <textarea id="history" name="history" rows="4"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('history', $schoolProfile->history) }}</textarea>
                                    @error('history')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Update Profil Sekolah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
