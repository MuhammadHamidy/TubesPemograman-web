<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KiQualls - Tempat Belajar dan Bermain')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-sky-200">
    <div class="min-h-screen flex flex-col items-center justify-center p-4 relative">
        <!-- Clouds Container -->
        <div class="fixed w-full h-full pointer-events-none">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 1" class="cloud-float absolute w-32 opacity-100 top-10 left-0">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 2" class="cloud-float-reverse absolute w-40 opacity-100 top-40 right-0">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 3" class="cloud-float-slow absolute w-36 opacity-100 top-60 left-1/4">
        </div>

        <!-- Navigation Bar -->
        <nav class="bg-blue-200 p-4 w-full">
            <div class="container mx-auto flex items-center justify-between">
                <a href="{{ route('landingPage') }}" class="text-xl font-bold">KiQualls</a>
                <div>
                    @auth
                        <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Home</a>
                        <a href="{{ route('logout') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Logout</a>
                    @else
                        <a href="{{ route('signin') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Masuk</a>
                        <a href="{{ route('signup') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Daftar</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        {{$slot}}
    </div>
</body>
</html>
