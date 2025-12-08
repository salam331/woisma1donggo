@extends('layouts.guest')

@section('title', 'Profil Sekolah')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
        {{ __('Profil Sekolah') }}
    </h2>
@endsection

@section('content')

    {{-- HERO SECTION --}}
    <div class="relative bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-16 mb-10 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex items-center space-x-6">
            @if($profile->logo)
                <img src="{{ asset('storage/' . $profile->logo) }}"
                    class="w-28 h-28 bg-white rounded-xl shadow-md p-2 object-cover" alt="Logo">
            @endif
            <div>
                <h1 class="text-4xl font-extrabold tracking-wide">{{ $profile->name }}</h1>
                <p class="text-lg opacity-90 mt-1">{{ $profile->description ?? 'Sekolah menengah atas unggulan.' }}</p>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 pb-20">

        {{-- INFORMASI GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- INFORMASI DASAR --}}
            <div
                class="md:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 flex items-center">
                    <span class="material-icons mr-2 text-blue-600">info Informasi Dasar</span>
                </h2>

                <div class="space-y-3 text-gray-700 dark:text-gray-300">
                    <p><strong>Alamat:</strong><br>{{ $profile->address ?? '-' }}</p>
                    <p><strong>Telepon:</strong> {{ $profile->phone ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $profile->email ?? '-' }}</p>
                    <p><strong>Website:</strong> {!! $profile->website ?: '-' !!}</p>
                    <p><strong>Kepala Sekolah:</strong> {{ $profile->principal_name ?? '-' }}</p>
                </div>
            </div>

            {{-- VISI & MISI --}}
            <div class="md:col-span-2 space-y-8">

                @if($profile->vision)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                        <h2 class="text-2xl font-semibold mb-3 text-blue-700">Visi</h2>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            "{{ $profile->vision }}"
                        </p>
                    </div>
                @endif

                @if($profile->mission)
                    <div
                        class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                        <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-4">Misi</h2>
                        <div class="text-gray-700 dark:text-gray-300 space-y-2 leading-relaxed">
                            {!! nl2br(e($profile->mission)) !!}
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- GARIS PEMISAH --}}
        <div class="my-12 border-t border-gray-300 dark:border-gray-700"></div>

        {{-- SEJARAH & FASILITAS & PROGRAM --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- SEJARAH --}}
            @if($profile->history)
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700 md:col-span-1">
                    <h2 class="text-2xl font-semibold mb-4 text-blue-700">Sejarah</h2>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $profile->history }}
                    </p>
                </div>
            @endif

            {{-- FASILITAS --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Fasilitas</h2>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li>• Ruang kelas modern</li>
                    <li>• Laboratorium sains lengkap</li>
                    <li>• Perpustakaan digital</li>
                    <li>• Lapangan olahraga</li>
                    <li>• Aula serbaguna</li>
                </ul>
            </div>

            {{-- PROGRAM UNGGULAN --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Program Unggulan</h2>
                <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                    <li>• Program STEM</li>
                    <li>• Ekstrakurikuler olahraga & seni</li>
                    <li>• Program bahasa asing</li>
                    <li>• Pelatihan keterampilan hidup</li>
                </ul>
            </div>

        </div>

    </div>

@endsection