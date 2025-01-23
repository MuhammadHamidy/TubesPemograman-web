<x-layout_landingPage>
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
                        @if(isset($game['is_unlocked']) && !$game['is_unlocked'])
                            <p class="text-red-500 mt-2">
                                🔒 Perlu {{ $game['required_points'] }} poin
                            </p>
                        @endif
                    </div>
                </div>
                @if(!isset($game['is_unlocked']) || $game['is_unlocked'])
                    <div class="absolute bottom-4 right-4">
                        <a href="{{ route('games.show', $game['id']) }}" 
                           class="px-4 py-2 bg-blue-500 text-white rounded-lg opacity-0 hover:opacity-100 transition-opacity duration-300">
                            Mulai Bermain
                        </a>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</x-layout_landingPage>