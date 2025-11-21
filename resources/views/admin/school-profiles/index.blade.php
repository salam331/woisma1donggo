<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profil Sekolah
            </h2>
            <a href="{{ route('admin.school-profiles.edit', $profile) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Profil
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Informasi Dasar</h3>
                                <div class="mt-4 space-y-2">
                                    <p><strong>Nama Sekolah:</strong> {{ $profile->name }}</p>
                                    <p><strong>Alamat:</strong> {{ $profile->address ?? '-' }}</p>
                                    <p><strong>Telepon:</strong> {{ $profile->phone ?? '-' }}</p>
                                    <p><strong>Email:</strong> {{ $profile->email ?? '-' }}</p>
                                    <p><strong>Website:</strong> {!! $profile->website ?: '-' !!}</p>
                                    <p><strong>Kepala Sekolah:</strong> {{ $profile->principal_name ?? '-' }}</p>
                                </div>
                            </div>

                            @if($profile->logo)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Logo Sekolah</h3>
                                <div class="mt-4">
                                    <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Sekolah" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Deskripsi</h3>
                                <div class="mt-4">
                                    <p>{{ $profile->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Visi</h3>
                                <div class="mt-4">
                                    <p>{{ $profile->vision ?? 'Tidak ada visi.' }}</p>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Misi</h3>
                                <div class="mt-4">
                                    <p>{{ $profile->mission ?? 'Tidak ada misi.' }}</p>
                                </div>
                            </div>

                            @if($profile->history)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Sejarah</h3>
                                <div class="mt-4">
                                    <p>{{ $profile->history }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end">
                        <a href="{{ route('admin.school-profiles.edit', $profile) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Profil Sekolah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
