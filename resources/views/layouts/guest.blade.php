<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Administrasi SMAN 1 Donggo')</title>
    <link rel="icon" href="{{ asset('faviconn.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="flex flex-col min-h-screen">
    @include('components.header')

    <main class="flex-grow flex flex-col">
    <div class="flex-grow w-full">
        @yield('content')
    </div>
</main>

@include('components.footer')
</body>

</html>