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
                    <img src="{{ Auth::check() && Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('img/avatar.png') }}" 
                        alt="Profile Picture" 
                        class="w-12 h-12 rounded-full object-cover">
                    <div class="ml-4">
                        <p class="text-xl">Selamat Datang,</p>
                        <p class="text-2xl font-bold">{{ auth()->user()->name ?? 'Tamu' }}</p>
                        @auth
                            <div class="flex items-center mt-1">
                                <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-blue-900">{{ auth()->user()->points ?? 0 }} Poin</span>
                            </div>
                        @endauth
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
@stack('scripts')
</html>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>