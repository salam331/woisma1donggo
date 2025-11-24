<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Administrasi SMAN 1 Donggo')</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="flex flex-col min-h-screen">
    @include('components.header')

    <main class="flex-grow p-6 flex flex-col">
        @yield('content')
        <div class="flex-grow"></div>
    </main>

    @include('components.footer')
</body>
</html>
