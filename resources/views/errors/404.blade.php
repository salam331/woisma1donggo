@extends('layouts.guest')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-screen relative flex items-center justify-center 
            bg-gradient-to-br from-slate-900 via-indigo-900 to-slate-900 
            overflow-hidden px-4">

    {{-- Decorative blurred circles --}}
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-pink-600/30 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-lg w-full text-center 
                bg-white/10 backdrop-blur-xl 
                border border-white/20 
                rounded-3xl p-10 shadow-2xl">

        {{-- Icon --}}
        <div class="mx-auto mb-6 flex items-center justify-center 
                    w-24 h-24 rounded-full 
                    bg-indigo-500/20 text-indigo-300">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="h-12 w-12" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      stroke-width="1.8"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>

        {{-- Error Code --}}
        <h1 class="text-7xl font-extrabold text-white tracking-widest">
            404
        </h1>

        {{-- Title --}}
        <p class="mt-4 text-2xl font-semibold text-indigo-200">
            Halaman Tidak Ditemukan
        </p>

        {{-- Description --}}
        <p class="mt-3 text-indigo-100/80 leading-relaxed">
            Sepertinya halaman yang Anda cari tidak tersedia,
            telah dipindahkan, atau URL yang dimasukkan tidak valid.
        </p>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">

            <a href="{{ url('/') }}"
               class="inline-flex items-center justify-center
                      px-6 py-3 rounded-xl
                      bg-indigo-600 text-white
                      hover:bg-indigo-700
                      shadow-lg hover:shadow-xl
                      transition duration-300">
                Kembali ke Beranda
            </a>

            <a href="{{ url()->previous() }}"
               class="inline-flex items-center justify-center
                      px-6 py-3 rounded-xl
                      bg-white/10 text-indigo-100
                      hover:bg-white/20
                      border border-white/20
                      transition duration-300">
                Halaman Sebelumnya
            </a>
        </div>

        {{-- Extra hint --}}
        <p class="mt-8 text-sm text-indigo-200/60">
            Jika masalah berlanjut, silakan hubungi administrator sistem.
        </p>
    </div>
</div>
@endsection
