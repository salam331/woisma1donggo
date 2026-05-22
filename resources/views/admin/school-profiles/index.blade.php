@extends('layouts.app')

@section('title', 'Informasi Profil Sekolah')

@section('content')

<div class="py-10 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

        <!-- HEADER -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                @if($profile->logo)
                    <img src="{{ asset('storage/' . $profile->logo) }}" 
                         class="w-20 h-20 rounded-xl object-cover border-4 border-white shadow">
                @endif

                <div>
                    <h1 class="text-2xl font-bold">{{ $profile->name }}</h1>
                    <p class="text-sm opacity-90">{{ $profile->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT SIDE -->
            <div class="lg:col-span-1 space-y-6">

                <!-- INFORMASI -->
                <div class="bg-white p-5 rounded-2xl shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        📌 Informasi Dasar
                    </h3>

                    <div class="space-y-3 text-sm text-gray-700">
                        <p><span class="font-semibold">Telepon:</span> {{ $profile->phone ?? '-' }}</p>
                        <p><span class="font-semibold">Email:</span> {{ $profile->email ?? '-' }}</p>
                        <p><span class="font-semibold">Website:</span> {!! $profile->website ?: '-' !!}</p>
                        <p><span class="font-semibold">Kepala Sekolah:</span> 
                            <span class="text-blue-600 font-medium">
                                {{ $profile->principal_name ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- LOGO (OPSIONAL TAMBAHAN STYLE) -->
                @if($profile->logo)
                <div class="bg-white p-5 rounded-2xl shadow text-center hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🏫 Logo Sekolah</h3>
                    <img src="{{ asset('storage/' . $profile->logo) }}" 
                         class="mx-auto w-32 h-32 object-cover rounded-xl shadow-md">
                </div>
                @endif

            </div>

            <!-- RIGHT SIDE -->
            <div class="lg:col-span-2 space-y-6">

                <!-- DESKRIPSI -->
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">📖 Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $profile->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <!-- VISI MISI -->
                <div class="grid md:grid-cols-2 gap-6">

                    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">🎯 Visi</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $profile->vision ?? 'Tidak ada visi.' }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">🚀 Misi</h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ $profile->mission ?? 'Tidak ada misi.' }}
                        </p>
                    </div>

                </div>

                <!-- SEJARAH -->
                @if($profile->history)
                <div class="bg-white p-6 rounded-2xl shadow hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">📜 Sejarah</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $profile->history }}
                    </p>
                </div>
                @endif

            </div>
        </div>

        <!-- ACTION BUTTON -->
        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.school-profiles.edit', $profile) }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl shadow transition">
                ✏️ Edit Profil
            </a>
        </div>

    </div>
</div>

@endsection