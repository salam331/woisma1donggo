@extends('layouts.guest')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<section class="relative min-h-screen flex items-center justify-center
               bg-gradient-to-br from-blue-700 via-indigo-800 to-purple-800
               text-white overflow-hidden">

    {{-- Decorative blur --}}
    <div class="absolute -top-20 -left-20 w-96 h-96 bg-blue-400/30 rounded-full blur-3xl"></div>
    <div class="absolute top-1/3 -right-32 w-[500px] h-[500px] bg-purple-500/30 rounded-full blur-3xl"></div>

    {{-- Pattern --}}
    <div class="absolute inset-0 opacity-10 bg-[url('{{ asset('images/pattern.svg') }}')] bg-cover"></div>

    <div class="relative z-10 max-w-4xl text-center px-6">
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight drop-shadow-xl">
            Selamat Datang di <br>
            <span class="text-yellow-300">Sistem Informasi Akademik</span><br>
            SMAN 1 Donggo
        </h1>

        <p class="mt-8 text-xl md:text-2xl opacity-90">
            Solusi digital modern untuk manajemen akademik sekolah yang cepat dan terintegrasi.
        </p>

        <a href="{{ route('about') }}"
           class="mt-10 inline-flex items-center gap-3 bg-white text-indigo-700
                  font-semibold rounded-full px-10 py-4 shadow-xl
                  hover:scale-105 hover:shadow-2xl transition-all duration-300">
            Tentang Sekolah →
        </a>
    </div>
</section>


{{-- ================= ATMOSFER SLIDER ================= --}}
<section class="relative w-full py-28 bg-fixed bg-center bg-cover overflow-hidden"
         style="background-image: url('{{ asset('images/bg.jpeg') }}');">

    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-br
                from-blue-900/90 via-blue-800/80 to-indigo-900/90"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4">

        <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-white">
            ATMOSFER <span class="text-yellow-400">SMAN 1 DONGGO</span>
        </h2>

        <div class="relative">
            <div class="swiper atmosferSwiper">
                <div class="swiper-wrapper">

                    @php
                        $slides = [
                            'images/1.jpg',
                            'images/2.jpg',
                            'images/3.jpg',
                            'images/4.jpg',
                            'images/5.jpg',
                        ];
                    @endphp

                    @foreach ($slides as $slide)
                        <div class="swiper-slide group">
                            <div
                                class="relative h-[520px] rounded-2xl overflow-hidden shadow-2xl
                                       transition-all duration-700
                                       scale-90 opacity-60 blur-[1px]
                                       group-[.swiper-slide-active]:scale-100
                                       group-[.swiper-slide-active]:opacity-100
                                       group-[.swiper-slide-active]:blur-0">

                                <img src="{{ asset($slide) }}"
                                     class="w-full h-full object-cover"
                                     alt="Atmosfer Sekolah">

                                <div class="absolute inset-0 bg-black/20"></div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            {{-- Navigation --}}
            <div class="swiper-button-prev !left-4 !w-12 !h-12 bg-white/90 rounded-full shadow
                        after:!text-sm text-blue-700"></div>

            <div class="swiper-button-next !right-4 !w-12 !h-12 bg-white/90 rounded-full shadow
                        after:!text-sm text-blue-700"></div>
        </div>
    </div>
</section>


{{-- ================= STATISTIK ================= --}}
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold mb-12 text-primary">Statistik Sekolah</h2>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach([
                ['Siswa Aktif',850],
                ['Guru & Staff',65],
                ['Kelas',28],
                ['Prestasi',120],
            ] as $s)
            <div class="bg-white/80 backdrop-blur dark:bg-gray-800
                        p-8 rounded-2xl shadow-lg
                        hover:-translate-y-2 hover:shadow-2xl
                        transition-all duration-300">
                <p class="text-5xl font-extrabold text-primary mb-3">{{ $s[1] }}</p>
                <p class="text-gray-600 dark:text-gray-300 text-lg">{{ $s[0] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= KEUNGGULAN ================= --}}
<section class="py-24 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-14 text-primary">Keunggulan SMAN 1 Donggo</h2>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach([
                ['Fasilitas Lengkap','Bangunan modern & sarpras lengkap'],
                ['Guru Kompeten','Tenaga pendidik profesional'],
                ['Kurikulum Berkualitas','Kurikulum adaptif & relevan'],
                ['Pembinaan Karakter','Fokus disiplin & moral'],
            ] as $k)
            <div class="group p-8 bg-white dark:bg-gray-900 rounded-2xl shadow
                        hover:shadow-2xl transition-all">
                <svg class="h-14 w-14 mx-auto text-primary mb-4
                            group-hover:scale-110 group-hover:rotate-6
                            transition-transform">
                    <circle cx="28" cy="28" r="28" fill="currentColor" />
                </svg>
                <h3 class="font-semibold text-xl mb-2">{{ $k[0] }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $k[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= PRESTASI ================= --}}
<section class="py-24 bg-gradient-to-r from-indigo-700 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-14">Prestasi Sekolah</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['Juara 1 O2SN Kabupaten','2024'],
                ['Finalis OSN Nasional','2023'],
                ['Juara 2 Debat Bahasa','2024'],
            ] as $p)
            <div class="bg-white/10 backdrop-blur border border-white/20
                        p-8 rounded-2xl shadow-lg hover:shadow-2xl transition">
                <h3 class="text-xl font-semibold mb-2">{{ $p[0] }}</h3>
                <p class="opacity-80">Tahun {{ $p[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ================= TESTIMONI ================= --}}
<section class="py-24 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto text-center px-4">
        <h2 class="text-3xl font-bold mb-14 text-primary">Apa Kata Mereka?</h2>

        <div class="grid md:grid-cols-3 gap-10">
            @foreach([
                ['Andi – Alumni','Lingkungan belajar nyaman dan guru sangat peduli.'],
                ['Bu Sari – Guru','Administrasi jadi jauh lebih efisien.'],
                ['Rina – Siswa','Fasilitas lengkap bikin makin semangat belajar.'],
            ] as $t)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow
                        hover:shadow-2xl transition">
                <p class="italic text-gray-700 dark:text-gray-300 mb-4">“{{ $t[1] }}”</p>
                <h3 class="font-semibold text-lg text-primary">{{ $t[0] }}</h3>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection