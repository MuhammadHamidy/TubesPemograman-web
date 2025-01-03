<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $games = [
            [
                'id' => 'motorik-1',
                'title' => 'Motorik I',
                'subtitle' => 'Tebak Warna',
                'icon' => 'Motorik1.png'
            ],
            [
                'id' => 'motorik-2',
                'title' => 'Motorik II',
                'subtitle' => 'Berhitung',
                'icon' => 'Motorik2.png'
            ],
            [
                'id' => 'motorik-3',
                'title' => 'Motorik III',
                'subtitle' => 'Membaca',
                'icon' => 'Motorik3.png'
            ],
            [
                'id' => 'motorik-4',
                'title' => 'Motorik IV',
                'subtitle' => 'Tebak Bentuk',
                'icon' => 'Motorik4.png'
            ],
        ];
        
        return view('home_game', compact('games'));
    }

    private function validateAnswer($level, $answer)
    {
        $answers = [
            'motorik-1' => 'green', 
            'motorik-2' => '2',
            'motorik-3' => 'A',
            'motorik-4' => 'shape',
        ];
        return isset($answers[$level]) && $answers[$level] === $answer;
    }

    public function show($level){
        $questionData = $this->getQuestionByLevel($level);
        if (is_array($questionData) && isset($questionData[0])) {
            $question = $questionData[0];
        } else {
            $question = $questionData;
        }
        return view('game', compact('question', 'level'));
    }

    public function checkAnswer(Request $request){
        $isCorrect = $this->validateAnswer($request->level, $request->answer);
        
        if ($isCorrect) {
            return response()->json([
                'status' => 'success',
                'message' => 'Selamat jawaban Kamu benar..',
                'points' => 100
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Sayang Sekali jawaban Kamu Salah..',
            'points' => -50
        ]);
    }

    private function getQuestionByLevel($level){
        // Sample question data - in production, this would come from database
        $questions = [
            'motorik-1' => [
                [
                    'image' => '',
                    'question' => 'Mana balon yang berwarna hijau?',
                    'questionDesc' => '',
                    'options' => [
                        ['type' => 'image', 'value' => 'yellow', 'image' => 'Ballon_yellow.png'],
                        ['type' => 'image', 'value' => 'black', 'image' => 'Ballon_brown.png'],
                        ['type' => 'image', 'value' => 'green', 'image' => 'Ballon_green.png'],
                        ['type' => 'image', 'value' => 'blue', 'image' => 'Ballon_blue.png']
                    ],
                    'correct_answer' => 'green'
                ],
                [
                    'image' => '',
                    'question' => 'Mana balon yang berwarna Kuning?',
                    'questionDesc' => '',
                    'options' => [
                        ['type' => 'image', 'value' => 'yellow', 'image' => 'Ballon_yellow.png'],
                        ['type' => 'image', 'value' => 'black', 'image' => 'Ballon_brown.png'],
                        ['type' => 'image', 'value' => 'green', 'image' => 'Ballon_green.png'],
                        ['type' => 'image', 'value' => 'blue', 'image' => 'Ballon_blue.png']
                    ],
                    'correct_answer' => 'green'
                ]
            ],
            'motorik-2' => [
                'image' => '',
                'question' => 'Berapakah Jumlah 1 + 1 ?',
                'questionDesc' => '',
                'options' => [
                    ['type' => 'text', 'value' => '3'],
                    ['type' => 'text', 'value' => '2'],
                    ['type' => 'text', 'value' => '8'],
                    ['type' => 'text', 'value' => '10']
                ],
                'correct_answer' => '2'
            ],
            'motorik-3' => [
                'image' => '',
                'question' => 'M A K _ N. ',
                'questionDesc' => 'huruf apa yang hilang ?',
                'options' => [
                    ['type' => 'text', 'value' => 'C'],
                    ['type' => 'text', 'value' => 'K'],
                    ['type' => 'text', 'value' => 'I'],
                    ['type' => 'text', 'value' => 'A']
                ],
                'correct_answer' => 'A'
            ],
            'motorik-4' => [
                'image' => 'shapeQuest.png',
                'question' => '',
                'questionDesc' => 'Bentuk apakah gambar tersebut!',
                'options' => [
                    ['type' => 'image', 'value' => 'shape', 'image' => 'shape.png'],
                    ['type' => 'image', 'value' => 'ellipse', 'image' => 'ellipse.png'],
                    ['type' => 'image', 'value' => 'polygon', 'image' => 'polygon.png'],
                    ['type' => 'image', 'value' => 'star', 'image' => 'star.png']
                ],
                'correct_answer' => 'shape'
            ],
            // Add more questions for other levels
        ];

        return $questions[$level] ?? null;
    }
}