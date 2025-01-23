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
        
        $games = [
            [
                'id' => 'motorik-1',
                'title' => 'Motorik I',
                'subtitle' => 'Tebak Warna',
                'icon' => 'Motorik1.png',
                'required_points' => $this->pointsRequirements['motorik-1'],
                'is_unlocked' => true
            ],
            [
                'id' => 'motorik-2',
                'title' => 'Motorik II',
                'subtitle' => 'Berhitung',
                'icon' => 'Motorik2.png',
                'required_points' => $this->pointsRequirements['motorik-2'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-2']
            ],
            [
                'id' => 'motorik-3',
                'title' => 'Motorik III',
                'subtitle' => 'Membaca',
                'icon' => 'Motorik3.png',
                'required_points' => $this->pointsRequirements['motorik-3'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-3']
            ],
            [
                'id' => 'motorik-4',
                'title' => 'Motorik IV',
                'subtitle' => 'Tebak Bentuk',
                'icon' => 'Motorik4.png',
                'required_points' => $this->pointsRequirements['motorik-4'],
                'is_unlocked' => $userPoints >= $this->pointsRequirements['motorik-4']
            ],
        ];
        
        return view('home_game', compact('games'));
    }

    private function validateAnswer($level, $answer)
    {
        $question = Question::where('level', $level)->first();
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

        $question = Question::where('level', $level)
            ->inRandomOrder()
            ->with('options')
            ->first();

        if (!$question) {
            return redirect()->route('games.index')
                ->with('error', 'Level tidak ditemukan!');
        }

        $questionData = [
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

        return view('game', ['question' => $questionData, 'level' => $level]);
    }

    public function checkAnswer(Request $request)
    {
        $user = Auth::user();
        $isCorrect = $this->validateAnswer($request->level, $request->answer);
        
        if ($isCorrect) {
            $points = 100;
            $user->increment('points', $points);
            return response()->json([
                'status' => 'success',
                'message' => 'Selamat jawaban Kamu benar..',
                'points' => $points
            ]);
        }

        $points = -50;
        $newPoints = max(0, $user->points + $points);
        $user->update(['points' => $newPoints]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Sayang Sekali jawaban Kamu Salah..',
            'points' => $newPoints - $user->points
        ]);
    }
}