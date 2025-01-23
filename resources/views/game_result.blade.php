<x-layout_landingPage>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg p-8 text-center">
            <div class="mb-8">
                <img src="/asset/star.png" class="w-32 h-32 mx-auto mb-4">
                <h2 class="text-3xl font-bold text-blue-600 mb-2">Level Selesai!</h2>
                <p class="text-gray-600">Selamat kamu telah menyelesaikan level ini</p>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Jawaban Benar</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $correctAnswers }} / {{ $totalQuestions }}</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Poin</h3>
                    <div class="flex items-center justify-center space-x-2">
                        <span class="text-xl text-gray-600">{{ $initialPoints }}</span>
                        <span class="text-xl">→</span>
                        <span class="text-3xl font-bold text-blue-600">{{ $finalPoints }}</span>
                    </div>
                    <span class="text-sm {{ $pointsChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $pointsChange >= 0 ? '+' : '' }}{{ $pointsChange }} poin
                    </span>
                </div>
            </div>

            <div class="flex justify-center space-x-4">
                <a href="{{ route('games.index') }}" class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Kembali ke Menu
                </a>
                <a href="{{ route('games.show', ['level' => $level]) }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Main Lagi
                </a>
            </div>
        </div>
    </div>
</x-layout_landingPage> 