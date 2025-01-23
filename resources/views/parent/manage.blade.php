<x-layout_landingPage>
    <div class="container mx-auto p-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-8 shadow-lg max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-blue-900 mb-6">Data Anak</h1>

            <!-- Form untuk menambah anak -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4">Hubungkan dengan Akun Anak</h2>
                <form action="{{ route('parent.link-child') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2">Email Anak</label>
                        <input type="email" name="child_email" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md"
                               placeholder="Masukkan email akun anak">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        Hubungkan
                    </button>
                </form>
            </div>

            <!-- Daftar anak yang terhubung -->
            <div>
                <h2 class="text-lg font-semibold mb-4">Daftar Anak</h2>
                @if($children->isEmpty())
                    <p class="text-gray-500">Belum ada anak yang terhubung</p>
                @else
                    <div class="space-y-4">
                        @foreach($children as $child)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold">{{ $child->name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $child->email }}</p>
                                    </div>
                                    <a href="{{ route('parent.child-progress', $child->id) }}" 
                                       class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                        Lihat Progress
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout_landingPage>