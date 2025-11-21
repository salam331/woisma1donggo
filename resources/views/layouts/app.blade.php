<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- cara include layouts sesuai dengan role --}}
            @auth
                @if(Auth::user()->hasRole('admin'))
                    @include('layouts.navigation-admin')
                @elseif(Auth::user()->hasRole('guru'))
                    @include('layouts.navigation-guru')
                @elseif(Auth::user()->hasRole('siswa'))
                    @include('layouts.navigation-siswa')
                @elseif(Auth::user()->hasRole('orang_tua'))
                    @include('layouts.navigation-orangtua')
                @else
                    @include('layouts.navigation-publik')
                @endif
            @else
                @include('layouts.navigation-publik')
            @endauth

            {{-- @include('layouts.navigation-admin') --}}

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
