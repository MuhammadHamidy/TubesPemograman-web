<x-layout_landingPage>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white/80 backdrop-blur-sm p-8 rounded-xl shadow-lg max-w-md w-full">
            <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Masuk sebagai Orang Tua</h2>
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('parent.signin.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Nama Pengguna Anak</label>
                    <input type="text" name="child_username" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('child_username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Password Orang Tua</label>
                    <input type="password" name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition-colors">
                    Masuk
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Kembali ke 
                <a href="{{ route('landingPage') }}" class="text-blue-500 hover:text-blue-600">
                    Halaman Utama
                </a>
            </p>
        </div>
    </div>
</x-layout_landingPage> 