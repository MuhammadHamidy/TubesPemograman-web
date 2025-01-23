<x-layout_landingPage>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-600">Waktu</span>
                <span class="text-sm text-gray-600">Pertanyaan {{ $currentQuestion }} dari {{ $totalQuestions }}</span>
            </div>
            <div class="relative w-full h-4 bg-gray-200 rounded-full">
                <div id="timer-bar" class="absolute top-0 left-0 h-full bg-blue-500 rounded-full"></div>
            </div>
        </div>
        <div class="bg-white rounded-lg p-8">
            @if($question['image'])
            <div class="mb-4">
                <img src="{{ asset('storage/' . $question['image']) }}" class="w-60 mx-auto">
            </div>
            @endif
            <h2 class="text-2xl font-bold mb-6">{{ $question['question'] }}</h2>
            <p class="text-1xl mb-6">{{ $question['questionDesc'] }}</p>
            <div class="grid grid-cols-2 gap-4">
                @foreach($question['options'] as $option)
                <button 
                    class="p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 transition-colors"
                    onclick="checkAnswer('{{ $option['value'] }}')"
                >
                    @if($option['type'] == 'image')
                        <img src="{{ asset('storage/' . $option['image']) }}" class="w-50">
                    @elseif($option['type'] == 'text')
                        <span class="text-xl">{{ $option['value'] }}</span>
                    @endif
                </button>
                @endforeach
            </div>
        </div>
    </div>
    
    <script>
        let timerBar = document.getElementById('timer-bar');
        let timeLeft = 30; // Set initial time in seconds
        let totalTime = 30; // Total time for the timer in seconds

        function updateTimer() {
            // Calculate the width percentage of the timer bar
            let widthPercentage = (timeLeft / totalTime) * 100;
            timerBar.style.width = widthPercentage + '%'; // Update the width of the timer bar

            if (timeLeft <= 0) {
                clearInterval(timerInterval); // Stop the timer when it reaches 0
                alert('Time is up!'); // Show alert when the time is up
            } else {
                timeLeft--;
            }
        }

        // Update the timer every second
        let timerInterval = setInterval(updateTimer, 1000);
        
        function checkAnswer(answer) {
            fetch('{{ route('games.checkAnswer') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    level: '{{ $level }}',
                    answer: answer,
                    question_id: {{ $question['id'] }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showResult(true, data.message, data.points, data.hasNext);
                } else {
                    showResult(false, data.message, data.points, data.hasNext);
                }
            });
        }
        
        function showResult(isCorrect, message, points, hasNext) {
            // Create result modal
            const modal = document.createElement('div');
            modal.className = `fixed inset-0 flex items-center justify-center bg-black bg-opacity-50`;
            modal.innerHTML = `
                <div class="bg-white p-8 rounded-lg text-center">
                    <div class="mb-4">
                        <img src="${isCorrect ? '/asset/CheckBox.png' : '/asset/FalseBox.png'}" class="w-16 h-16 mx-auto">
                    </div>
                    <h3 class="text-xl font-bold ${isCorrect ? 'text-green-600' : 'text-red-600'}">${message}</h3>
                    <p class="mt-2">Poin: ${points >= 0 ? '+' + points : points}</p>
                    <div class="mt-6 flex justify-center">
                        ${hasNext ? 
                            `<button onclick="nextQuestion()" class="px-4 py-2 bg-blue-500 text-white rounded">Selanjutnya</button>` : 
                            `<button onclick="showResults()" class="px-4 py-2 bg-blue-500 text-white rounded">Lihat Hasil</button>`
                        }
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        function showResults() {
            window.location.href = '{{ route('games.show', ['level' => $level]) }}';
        }
        
        function nextQuestion() {
            window.location.href = '{{ route('games.show', ['level' => $level]) }}';
        }
    </script>
</x-layout_landingPage>

{{-- Tahap Perbaikan --}}
