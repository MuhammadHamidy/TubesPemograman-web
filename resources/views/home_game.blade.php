<x-layout_landingPage>
    <!-- Points Warning Modal -->
    <div id="pointsWarningModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center" style="z-index: 9999;">
        <div class="bg-white p-8 rounded-lg shadow-xl max-w-md w-full mx-4 relative">
            <div class="text-center">
                <div class="mb-4 text-red-500">
                    <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Poin Tidak Cukup!</h3>
                <p class="text-gray-600" id="pointsWarningText"></p>
            </div>
            <div class="mt-6 flex justify-center">
                <button onclick="closePointsWarning()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Permainan</h1>
        
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-2 gap-6">
            @foreach($games as $game)
            <div class="relative block p-6 bg-white rounded-lg shadow {{ isset($game['is_unlocked']) && !$game['is_unlocked'] ? 'opacity-75' : '' }}">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('asset/' . $game['icon']) }}" class="w-16 h-16">
                    <div class="ml-4">
                        <h2 class="text-xl font-bold">{{ $game['title'] }}</h2>
                        <p class="text-gray-600">{{ $game['subtitle'] }}</p>
                        <p class="text-sm text-gray-500">{{ $game['question_count'] }} Soal</p>
                        <p class="{{ isset($game['is_unlocked']) && $game['is_unlocked'] ? 'line-through text-gray-500' : 'text-red-500' }} mt-2">
                            🔒 Perlu {{ $game['required_points'] }} poin
                        </p>
                    </div>
                </div>
                <div class="absolute bottom-4 right-4">
                    @if(!isset($game['is_unlocked']) || $game['is_unlocked'])
                        <a href="{{ route('games.show', $game['id']) }}" 
                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Mulai Bermain
                        </a>
                    @else
                        <button onclick="showPointsWarning({{ $game['required_points'] }})"
                                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Mulai Bermain
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function showPointsWarning(requiredPoints) {
            const modal = document.getElementById('pointsWarningModal');
            const warningText = document.getElementById('pointsWarningText');
            warningText.textContent = `Maaf, kamu membutuhkan ${requiredPoints} poin untuk memainkan game ini!`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePointsWarning() {
            const modal = document.getElementById('pointsWarningModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('pointsWarningModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePointsWarning();
            }
        });
    </script>
</x-layout_landingPage>