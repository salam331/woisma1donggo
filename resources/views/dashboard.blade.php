@extends('layouts.guest')

@section('content')

<!-- HERO SECTION MODERN -->
<section class="relative bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-700 text-white py-28 px-6 overflow-hidden">
    <div class="absolute inset-0 opacity-20 bg-[url('{{ asset('images/pattern.svg') }}')] bg-cover"></div>

    <div class="max-w-7xl mx-auto relative z-10 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight drop-shadow-lg">
            Selamat Datang di <br> Sistem Administrasi SMAN 1 Donggo
        </h1>

        <p class="mt-6 text-xl md:text-2xl opacity-90">
            Solusi digital untuk mempercepat manajemen sekolah dengan tampilan modern & responsif.
        </p>

        <a href="{{ route('about') }}"
            class="mt-8 inline-block bg-white text-indigo-700 font-semibold rounded-xl px-10 py-4 shadow-lg hover:bg-gray-100 transition">
            Tentang Sekolah
        </a>
    </div>
</section>


<!-- SLIDER GAMBAR FULL-WIDTH -->
<section class="relative w-full overflow-hidden">
    <div x-data="{
        activeSlide: 0,
        slides: [
            '{{ asset('images/slide1.jpg') }}',
            '{{ asset('images/slide2.jpg') }}',
            '{{ asset('images/slide3.jpg') }}'
        ],
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        },
        autoplay() {
            setInterval(() => { this.next(); }, 5000);
        }
    }" x-init="autoplay()" class="relative">
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index"
                class="w-full h-96 bg-cover bg-center transition-opacity ease-in-out duration-700"
                :style="`background-image: url('${slide}');`">
                <div class="flex items-end justify-center w-full h-full bg-gray-900 bg-opacity-50">
                    <h2 class="text-3xl font-bold text-white text-center px-4" x-text="`Caption for Slide ${index + 1}`"></h2>
                </div>
            </div>
        </template>

        <!-- Navigation Buttons -->
        <button @click="prev()"
            class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full ml-4 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        {{-- tambahkan icon < > yang bisa diklik untuk melihat slide gambar --}}
        <button @click="next()"
            class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full mr-4 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>


<!-- STATISTIK SEKOLAH -->
<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-10 text-primary">Statistik Sekolah</h2>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach([
                ['title'=>'Siswa Aktif','value'=>850],
                ['title'=>'Guru & Staff','value'=>65],
                ['title'=>'Rombel','value'=>28],
                ['title'=>'Prestasi','value'=>120],
            ] as $item)
                <div class="bg-white dark:bg-gray-900 shadow-md p-8 rounded-xl hover:shadow-xl transition">
                    <p class="text-5xl font-extrabold text-primary mb-3">{{ $item['value'] }}</p>
                    <p class="text-gray-600 dark:text-gray-300 text-lg">{{ $item['title'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


<!-- KOMPONEN KEUNGGULAN -->
<section class="py-20 px-6">
    <div class="max-w-7xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 text-primary">Keunggulan SMAN 1 Donggo</h2>

        <div class="grid md:grid-cols-4 gap-8">
            @foreach([
                ['Fasilitas Lengkap','Bangunan modern & sarpras lengkap'],
                ['Guru Kompeten','Tenaga pendidik profesional & berpengalaman'],
                ['Kurikulum Berkualitas','Kurikulum modern sesuai kebutuhan industri'],
                ['Pembinaan Karakter','Fokus pada karakter dan kedisiplinan siswa'],
            ] as $item)
            <div class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow hover:shadow-xl transition">
                <svg class="h-14 w-14 mx-auto text-primary mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" />
                </svg>
                <h3 class="font-semibold text-xl mb-2">{{ $item[0] }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ $item[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- PRESTASI TERBARU SECTION -->
<section class="py-20 bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-12">Prestasi Sekolah</h2>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['Juara 1 O2SN Kabupaten','2024'],
                ['Finalis Olimpiade Sains Nasional','2023'],
                ['Juara 2 Lomba Debat Bahasa Indonesia','2024'],
            ] as $p)
            <div class="bg-white/10 p-6 rounded-xl backdrop-blur-md shadow">
                <h3 class="text-xl font-semibold mb-2">{{ $p[0] }}</h3>
                <p class="opacity-80">Tahun {{ $p[1] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- TESTIMONI -->
<section class="py-20 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto text-center">
        <h2 class="text-3xl font-bold mb-12 text-primary">Apa Kata Mereka?</h2>

        <div class="grid md:grid-cols-3 gap-10">
            @foreach([
                ['Andi – Alumni','“Sekolah dengan lingkungan belajar yang nyaman dan guru-guru yang sangat peduli.”'],
                ['Bu Sari – Guru','“Sistem administrasi digital ini sangat membantu kegiatan belajar mengajar.”'],
                ['Rina – Siswa','“Fasilitas lengkap membuat saya lebih semangat belajar!”'],
            ] as $t)
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow hover:shadow-lg transition">
                <p class="italic text-gray-700 dark:text-gray-300 mb-4">{{ $t[1] }}</p>
                <h3 class="font-semibold text-lg text-primary">{{ $t[0] }}</h3>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
