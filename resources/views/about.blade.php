<x-publik-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        @if($profile->logo)
                            <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo {{ $profile->name }}" class="w-24 h-24 mr-6 rounded-lg">
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold">{{ $profile->name }}</h1>
                            <p class="text-lg text-gray-600">{{ $profile->description ?? 'Sekolah menengah atas unggulan.' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Informasi Dasar</h2>
                                <div class="space-y-2">
                                    <p><strong>Alamat:</strong> {{ $profile->address ?? '-' }}</p>
                                    <p><strong>Telepon:</strong> {{ $profile->phone ?? '-' }}</p>
                                    <p><strong>Email:</strong> {{ $profile->email ?? '-' }}</p>
                                    <p><strong>Website:</strong> {!! $profile->website ?: '-' !!}</p>
                                    <p><strong>Kepala Sekolah:</strong> {{ $profile->principal_name ?? '-' }}</p>
                                </div>
                            </div>

                            @if($profile->vision)
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Visi</h2>
                                <p>{{ $profile->vision }}</p>
                            </div>
                            @endif

                            @if($profile->mission)
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Misi</h2>
                                <p>{{ $profile->mission }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            @if($profile->history)
                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Sejarah</h2>
                                <p>{{ $profile->history }}</p>
                            </div>
                            @endif

                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Fasilitas</h2>
                                <ul class="list-disc list-inside space-y-2">
                                    <li>Ruang kelas yang nyaman dan modern</li>
                                    <li>Laboratorium sains lengkap</li>
                                    <li>Perpustakaan digital</li>
                                    <li>Lapangan olahraga</li>
                                    <li>Aula serbaguna</li>
                                </ul>
                            </div>

                            <div>
                                <h2 class="text-2xl font-semibold mb-4">Program Unggulan</h2>
                                <ul class="list-disc list-inside space-y-2">
                                    <li>Program STEM (Science, Technology, Engineering, Mathematics)</li>
                                    <li>Ekstrakurikuler olahraga dan seni</li>
                                    <li>Program bahasa asing</li>
                                    <li>Pelatihan keterampilan hidup</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-publik-layout>
