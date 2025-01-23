<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KiQualls' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-sky-200">
    <div class="min-h-screen flex flex-col">
        <!-- Clouds Container -->
        <div class="fixed w-full h-full pointer-events-none">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 1" class="cloud-float absolute w-32 opacity-100 top-10 left-0">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 2" class="cloud-float-slow absolute w-40 opacity-100 top-40 right-1/2">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 3" class="cloud-float-slow absolute w-36 opacity-100 top-80 left-1/4">
            <img src="{{ asset('img/matahari.png') }}" alt="Sun" class="absolute w-20 opacity-100 top-10 right-10">
        </div>

        <!-- Navigation Bar -->
        <nav class="bg-blue-300 p-4 shadow">
            <div class="container mx-auto flex items-center">
                <div class="flex items-center">
                    <img src="{{ asset('img/avatar.png') }}" class="w-12 h-12 rounded-full">
                    <div class="ml-4">
                        <p class="text-xl">Selamat Datang,</p>
                        <p class="text-2xl font-bold">{{ auth()->user()->name ?? 'Tamu' }}</p>
                    </div>
                </div>
                <div class="ml-auto flex space-x-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Utama</a>
                    <a href="{{ route('games.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Permainan</a>
                    <a href="{{ route('profile') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto p-4">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
