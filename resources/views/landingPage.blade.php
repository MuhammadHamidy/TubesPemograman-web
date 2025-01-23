<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KiQualls - Tempat Belajar dan Bermain</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-sky-200 overflow-hidden">
    <!-- Clouds Container -->
    <div class="fixed w-full h-full pointer-events-none">
        <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 1" class="cloud-float absolute w-32 opacity-100 top-20 left-0">
        <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 2" class="cloud-float-reverse absolute w-40 opacity-100 top-40 right-0">
        <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 3" class="cloud-float-slow absolute w-36 opacity-100 top-60 left-1/4">
    </div>

    <div class="min-h-screen flex flex-col items-center justify-center p-4 relative">
        <!-- Main Content Container -->
        <div class="max-w-4xl w-full flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- Left Side - Text Content -->
            <div class="text-center md:text-left space-y-4">
                <h1 class="welcome-text text-4xl md:text-5xl font-bold">
                    Selamat Datang,
                </h1>
                <p class="text-xl md:text-2xl text-sky-800">
                    Tempat dimana untuk belajar<br>dan bermain
                </p>
                <!-- Button Container -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <!-- Masuk Button -->
                    <div class="relative">
                        <button 
                            onclick="document.getElementById('dropdownMenu').classList.toggle('hidden')"
                            class="bg-blue-500 text-white px-8 py-2 rounded-md hover:bg-blue-600 transition-colors w-full sm:w-auto flex items-center justify-center gap-2">
                            Masuk
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" id="dropdownArrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu" class="hidden absolute left-0 mt-2 w-full sm:w-48 bg-blueSky rounded-md shadow-lg py-1 z-10">
                            <a href="{{ route('signin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white transition-colors">
                                Sebagai Anak
                            </a>
                            <a href="{{ route('signin') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-white transition-colors">
                                Sebagai Orang Tua
                            </a>
                        </div>
                    </div>
                    <!-- Daftar Button -->
                    <button class="bg-blue-500 text-white px-8 py-2 rounded-md hover:bg-blue-600 transition-colors w-full sm:w-auto">
                        <a href="{{ route('signup') }}" class="">
                            Daftar
                        </a>
                    </button>
                </div>
            </div>

            <!-- Right Side - Logo -->
            <div class="w-64 md:w-80">
                <div class="relative">
                    <!-- Decorative Flags -->
                    <div class="absolute -top-4 -right-4 flex gap-2">
                        <div class="w-4 h-4 bg-blue-400 rounded-sm transform rotate-45"></div>
                        <div class="w-4 h-4 bg-red-400 rounded-sm transform rotate-45"></div>
                        <div class="w-4 h-4 bg-green-400 rounded-sm transform rotate-45"></div>
                        <div class="w-4 h-4 bg-yellow-400 rounded-sm transform rotate-45"></div>
                    </div>
                    <!-- Logo and Character -->
                    <div class="relative">
                        <img src="{{ asset('img/logo_kiquals.png') }}" alt="KiQualls Mascot" class="w-full h-auto">
                        {{-- <h2 class="text-3xl font-bold text-yellow-400 absolute bottom-0 left-1/2 transform -translate-x-1/2 drop-shadow-lg">
                            KiQUALLS
                        </h2> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>