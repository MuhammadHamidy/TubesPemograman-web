<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KiQualls')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-200">
    <div class="min-h-screen flex flex-col items-center justify-center p-4 relative">
        <!-- Clouds Container -->
        <div class="fixed w-full h-full pointer-events-none">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 1" class="cloud-float absolute w-32 opacity-100 top-10 left-0">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 2" class="cloud-float-slow absolute w-40 opacity-100 top-40 right-1/2">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud 3" class="cloud-float-slow absolute w-36 opacity-100 top-80 left-1/4">
            <img src="{{ asset('img/clouds1.png') }}" alt="Cloud4" class="absolute w-40 opacity-100 top-100 right-0">
            <img src="{{ asset('img/matahari.png') }}" alt="Sun" class="absolute w-20 opacity-100 top-100 right-0">
        </div>

        <!-- Page Content -->
        {{$slot}}

        @stack('scripts')
    </div>
</body>
</html>
