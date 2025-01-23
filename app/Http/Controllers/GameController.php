<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\GameHistory;

class GameController extends Controller
{
    private $pointsRequirements = [
        'motorik-1' => 0,      // First level is free
        'motorik-2' => 300,    // Need 300 points
        'motorik-3' => 600,    // Need 600 points
        'motorik-4' => 900,    // Need 900 points
    ];

    public function index()
    {
        $user = Auth::user();
        $userPoints = $user->points ?? 0;
        
        // Get question counts for each level
        $questionCounts = [
            'motorik-1' => Question::where('level', 'motorik-1')->count(),
            'motorik-2' => Question::where('level', 'motorik-2')->count(),
            'motorik-3' => Question::where('level', 'motorik-3')->count(),
            'motorik-4' => Question::where('level', 'motorik-4')->count(),
        ];
        
        $games = [
            [
                'id' => 'motorik-1',
                'title' => 'Motorik I',
                'subtitle' => 'Tebak Warna',
                'icon' => 'Motorik1.png',
                'required_points' => $this->pointsRequirements['motorik-1'],
                'is_unlocked' => true,
                'question_count' => $questionCounts['motorik-1'] ?? 0
            ],
            [
                'id' => 'motorik-2',
                'title' => 'Motorik II',
                'subtitle' => 'Berhitung',
                'icon' => 'Motorik2.png',
                'required_points' => $this->pointsRequirements['motorik-2'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-2'],
                'question_count' => $questionCounts['motorik-2'] ?? 0
            ],
            [
                'id' => 'motorik-3',
                'title' => 'Motorik III',
                'subtitle' => 'Membaca',
                'icon' => 'Motorik3.png',
                'required_points' => $this->pointsRequirements['motorik-3'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-3'],
                'question_count' => $questionCounts['motorik-3'] ?? 0
            ],
            [
                'id' => 'motorik-4',
                'title' => 'Motorik IV',
                'subtitle' => 'Tebak Bentuk',
                'icon' => 'Motorik4.png',
                'required_points' => $this->pointsRequirements['motorik-4'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-4'],
                'question_count' => $questionCounts['motorik-4'] ?? 0
            ],
        ];
        
        return view('games.index', compact('games'));
    }

    private function validateAnswer($level, $answer, $questionId)
    {
        $question = Question::where('id', $questionId)->where('level', $level)->first();
        return $question && $question->correct_answer === $answer;
    }

    public function show($level)
    {
        $user = Auth::user();
        $userPoints = $user->points ?? 0;
        
        if ($userPoints < $this->pointsRequirements[$level]) {
            return redirect()->route('games.index')
                ->with('error', 'Kamu perlu ' . $this->pointsRequirements[$level] . ' poin untuk membuka level ini!');
        }

        // Check if we're starting a new level (no answered questions or different level)
        $currentLevel = session()->get('current_level');
        if ($currentLevel !== $level) {
            session()->forget(['answered_questions', 'correct_answers', 'initial_points']);
            session()->put([
                'current_level' => $level,
                'initial_points' => $userPoints,
                'correct_answers' => 0
            ]);
        }

        // Get answered questions from session
        $answeredQuestions = session()->get('answered_questions', []);
        
        $question = Question::where('level', $level)
            ->whereNotIn('id', $answeredQuestions)
            ->orderBy('id', 'asc')  // Get questions in sequential order
            ->with('options')
            ->first();

        if (!$question) {
            $totalQuestions = Question::where('level', $level)->count();
            $correctAnswers = session()->get('correct_answers', 0);
            $initialPoints = session()->get('initial_points', $userPoints);
            $finalPoints = $user->points;
            $pointsChange = $finalPoints - $initialPoints;

            // Record game history
            GameHistory::create([
                'user_id' => $user->id,
                'level' => $level,
                'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
                'points_earned' => $pointsChange,
                'points_before' => $initialPoints,
                'points_after' => $finalPoints
            ]);

            // Reset session data
            session()->forget(['answered_questions', 'current_level', 'correct_answers', 'initial_points']);

            return view('game_result', [
                'level' => $level,
                'correctAnswers' => $correctAnswers,
                'totalQuestions' => $totalQuestions,
                'initialPoints' => $initialPoints,
                'finalPoints' => $finalPoints,
                'pointsChange' => $pointsChange
            ]);
        }

        $questionData = [
            'id' => $question->id,
            'image' => $question->image,
            'question' => $question->question,
            'questionDesc' => $question->question_desc,
            'options' => $question->options->map(function($option) {
                return [
                    'type' => $option->type,
                    'value' => $option->value,
                    'image' => $option->image
                ];
            })->toArray()
        ];

        // Get total questions and current question number
        $totalQuestions = Question::where('level', $level)->count();
        $currentQuestionNumber = count($answeredQuestions) + 1;

        return view('game', [
            'question' => $questionData, 
            'level' => $level,
            'currentQuestion' => $currentQuestionNumber,
            'totalQuestions' => $totalQuestions
        ]);
    }

    public function checkAnswer(Request $request)
    {
        $user = Auth::user();
        $isCorrect = $this->validateAnswer($request->level, $request->answer, $request->question_id);
        
        // Check if there are any remaining questions
        $answeredQuestions = session()->get('answered_questions', []);
        $answeredQuestions[] = $request->question_id;
        session()->put('answered_questions', $answeredQuestions);
        
        $remainingQuestions = Question::where('level', $request->level)
            ->whereNotIn('id', $answeredQuestions)
            ->exists();
        
        if ($isCorrect) {
            $points = 100;
            $user->increment('points', $points);
            // Increment correct answers counter
            $correctAnswers = session()->get('correct_answers', 0);
            session()->put('correct_answers', $correctAnswers + 1);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Selamat jawaban Kamu benar..',
                'points' => $points,
                'hasNext' => $remainingQuestions
            ]);
        }

        $points = -50;
        $newPoints = max(0, $user->points + $points);
        $user->update(['points' => $newPoints]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Sayang Sekali jawaban Kamu Salah..',
            'points' => $points,
            'hasNext' => $remainingQuestions
        ]);
    }
}