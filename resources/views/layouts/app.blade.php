<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 dark:bg-gray-900">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sistem Administrasi SMAN 1 Donggo')</title>
    <link rel="icon" href="{{ asset('faviconn.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="h-full">
    <div class="min-h-full flex">
        @include('components.sidebar-admin')
        <div class="flex-1 flex flex-col">
            @include('components.navbar-admin')
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
