<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Sistem Administrasi SMAN 1 Donggo')</title>
    <link rel="icon" href="{{ asset('faviconn2.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen">
    @include('components.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')
</body>
</html>
