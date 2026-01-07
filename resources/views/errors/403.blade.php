@extends('layouts.guest')

@section('title', '403 - Akses Ditolak')

@section('content')
<div class="min-h-screen flex items-center justify-center 
            bg-gradient-to-br from-red-50 via-white to-red-100 
            px-4">

    <div class="relative bg-white/90 backdrop-blur
                shadow-2xl rounded-2xl p-10 
                text-center max-w-md w-full
                border border-red-100">

        {{-- Icon --}}
        <div class="mx-auto mb-6 flex items-center justify-center 
                    w-20 h-20 rounded-full 
                    bg-red-100 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="h-10 w-10" fill="none" 
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M12 15v2m0-8v2m9 1a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        {{-- Error Code --}}
        <h1 class="text-6xl font-extrabold text-red-600 tracking-widest">
            403
        </h1>

        {{-- Title --}}
        <p class="mt-4 text-2xl font-semibold text-gray-800">
            Akses Ditolak
        </p>

        {{-- Description --}}
        <p class="mt-2 text-gray-600 leading-relaxed">
            Maaf, Anda tidak memiliki izin atau peran yang diperlukan
            untuk mengakses halaman ini.
        </p>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col sm:flex-row 
                    justify-center gap-3">

            <a href="{{ url()->previous() }}"
               class="inline-flex items-center justify-center
                      px-6 py-2.5 rounded-lg
                      bg-gray-100 text-gray-700
                      hover:bg-gray-200
                      transition duration-200">
                Kembali
            </a>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center justify-center
                      px-6 py-2.5 rounded-lg
                      bg-blue-600 text-white
                      hover:bg-blue-700
                      shadow-md hover:shadow-lg
                      transition duration-200">
                Dashboard
            </a>
        </div>

        {{-- Footer hint --}}
        <p class="mt-6 text-sm text-gray-400">
            Jika ini kesalahan, silakan hubungi administrator.
        </p>
    </div>
</div>
@endsection
