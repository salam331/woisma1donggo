<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Administrasi SMAN 1 Donggo')</title>
    <link rel="icon" href="{{ asset('faviconn.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="{{ asset('csss/mobile-table.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/trix@1.3.1/dist/trix.css">
<script src="https://unpkg.com/trix@1.3.1/dist/trix.js" defer></script>

<style>
    trix-editor {
        min-height: 200px;
        background: white;
        color: #111;
    }
</style>
</head>
<body class="h-full">
    <div class="min-h-full flex">
            {{-- buatkan jika login sebagai role lain maka akan include sidebar sesuai role yang ada--}}
            @if(Auth::check())
                @if(Auth::user()->hasRole('admin'))
                    @include('components.sidebar-admin')
                @elseif(Auth::user()->hasRole('guru'))
                    @include('components.sidebar-teacher')
                @elseif(Auth::user()->hasRole('siswa'))
                    @include('components.sidebar-student')
                @elseif (Auth::user()->hasRole('orang_tua'))
                    @include('components.sidebar-parent')
                @endif
            @endif
            <div class="flex-1 flex flex-col">
            @include('components.navbar-admin')
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
