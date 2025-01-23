<x-layout_main>
    <div class="w-full max-w-md">
        <div class="mt-5">
            @if ($errors->any())
                <div class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p>{{ $error }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif
        
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif
        </div>
        <!-- Logo -->
        <div class="flex justify-center mb-2">
            <img src="{{ asset('img/logo_kiquals.png') }}" alt="KiQualls Logo" class="w-32">
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-center mb-2">Masuk</h1>
        <p class="text-center text-gray-600 mb-8">Selamat datang di KiQualls</p>

        <!-- Login Form -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg">
            <form method="POST" action="{{ route('signin.post') }}" class="space-y-6">
                @csrf
                
                <!-- Username Field -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Pengguna</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Silakan masukkan username Anda" required>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Kata Sandi</label>
                    <input type="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Silakan masukkan kata sandi Anda" required>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Login
                </button>

                <!-- Register Link -->
                <div class="text-center text-sm">
                    <span class="text-gray-600">Belum punya akun? </span>
                    <a href="{{ route('signup') }}" class="text-blue-500 hover:text-blue-600">Daftar disini</a>
                </div>
            </form>
        </div>
    </div>
</x-layout_main>