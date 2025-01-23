<x-layout_landingPage>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Video Container -->
            <div class="max-w-xl mx-auto p-4">
                <div style="width: 560px; height: 315px;" class="mx-auto">
                    @if($tutorialVideo)
                        <video 
                            class="w-full h-full"
                            controls
                            preload="metadata">
                            <source src="{{ asset('storage/' . $tutorialVideo->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                            <p class="text-gray-500">Video tutorial belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content below video -->
            <div class="p-8 text-center">
                <h1 class="text-3xl font-bold mb-6">Selamat Datang di Game Edukasi</h1>
                <p class="text-gray-600 mb-8">Tonton video tutorial di atas untuk memahami cara bermain, lalu mulai petualanganmu!</p>
                <a href="{{ route('games.index') }}" 
                   class="inline-block px-8 py-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors text-lg font-semibold">
                    Main Sekarang
                </a>
            </div>
        </div>
    </div>
</x-layout_landingPage>