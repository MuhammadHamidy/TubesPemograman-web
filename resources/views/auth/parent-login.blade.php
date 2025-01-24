<x-layout_main>
    <!-- Register Container -->
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
        </div>

        <!-- Logo -->
        <div class="flex justify-center mb-2">
            <img src="{{ asset('img/logo_kiqualls.png') }}" alt="KiQualls Logo" class="w-32">
        </div>

        <!-- Title -->
        <h1 class="text-4xl font-bold text-center mb-2">Masuk Orang Tua</h1>
        <p class="text-center text-gray-600 mb-8">Akses profil anak Anda</p>

        <!-- Login Form -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg">
            <form class="space-y-6" action="{{ route('parent.login') }}" method="POST">
                @csrf
                <!-- Child Name Field -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Anak</label>
                    <input id="name" name="name" type="text" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama anak">
                </div>

                <!-- Child Password Field -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Kata Sandi Anak</label>
                    <input id="password" name="password" type="password" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan kata sandi anak">
                </div>

                <!-- Mother's Name Field -->
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Ibu Kandung</label>
                    <input id="mother_name" name="mother_name" type="text" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan nama ibu kandung">
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Masuk
                </button>

                <!-- Back to Home Link -->
                <div class="text-center text-sm">
                    <a href="{{ route('landingPage') }}" class="text-blue-500 hover:text-blue-600">Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>
</x-layout_main> 