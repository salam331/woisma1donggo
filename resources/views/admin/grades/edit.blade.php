<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">
    <div class="text-center">
        
        <!-- ICON / ANIMATION -->
        <div class="mb-8">
            <svg class="w-40 h-40 mx-auto float" fill="none" stroke="currentColor" stroke-width="1.5"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3m0 3h.01m-6.938 4h13.856c1.54 0
                         2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                         0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <!-- CODE -->
        <h1 class="text-7xl font-extrabold text-gray-800 tracking-wide mb-4">
            404
        </h1>

        <!-- MESSAGE -->
        <p class="text-lg text-gray-600 mb-8">
            Halaman yang kamu cari tidak ditemukan.  
            <br> Lain Kali Ga Boleh Macam-Macam.
        </p>

        <!-- BUTTONS -->
        <div class="flex items-center justify-center gap-4">
            <a href="{{ url()->previous() }}"
               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg shadow
                      transition">
                Kembali
            </a>

            <a href="{{ route('admin.dashboard') }}"
               class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow
                      transition">
                Ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
