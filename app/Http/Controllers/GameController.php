<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;

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
                'question_count' => $questionCounts['motorik-1']
            ],
            [
                'id' => 'motorik-2',
                'title' => 'Motorik II',
                'subtitle' => 'Berhitung',
                'icon' => 'Motorik2.png',
                'required_points' => $this->pointsRequirements['motorik-2'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-2'],
                'question_count' => $questionCounts['motorik-2']
            ],
            [
                'id' => 'motorik-3',
                'title' => 'Motorik III',
                'subtitle' => 'Membaca',
                'icon' => 'Motorik3.png',
                'required_points' => $this->pointsRequirements['motorik-3'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-3'],
                'question_count' => $questionCounts['motorik-3']
            ],
            [
                'id' => 'motorik-4',
                'title' => 'Motorik IV',
                'subtitle' => 'Tebak Bentuk',
                'icon' => 'Motorik4.png',
                'required_points' => $this->pointsRequirements['motorik-4'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-4'],
                'question_count' => $questionCounts['motorik-4']
            ],
        ];
        
        return view('home_game', compact('games'));
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
            session()->forget('answered_questions');
            session()->put('current_level', $level);
        }

        // Get answered questions from session
        $answeredQuestions = session()->get('answered_questions', []);
        
        $question = Question::where('level', $level)
            ->whereNotIn('id', $answeredQuestions)
            ->orderBy('id', 'asc')  // Get questions in sequential order
            ->with('options')
            ->first();

        if (!$question) {
            // Reset answered questions and current level when level is completed
            session()->forget(['answered_questions', 'current_level']);
            return redirect()->route('games.index')
                ->with('success', 'Selamat! Kamu telah menyelesaikan semua pertanyaan di level ini!');
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
            'points' => $newPoints - $user->points,
            'hasNext' => $remainingQuestions
        ]);
    }
}