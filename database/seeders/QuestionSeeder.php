<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionOption;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Motorik-1 Question 1
        $question1 = Question::create([
            'level' => 'motorik-1',
            'question' => 'Mana balon yang berwarna hijau?',
            'question_desc' => '',
            'image' => '',
            'correct_answer' => 'green'
        ]);

        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'yellow',
            'image' => 'Ballon_yellow.png'
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'black',
            'image' => 'Ballon_brown.png'
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'green',
            'image' => 'Ballon_green.png'
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'blue',
            'image' => 'Ballon_blue.png'
        ]);

        // Motorik-2 Question
        $question2 = Question::create([
            'level' => 'motorik-2',
            'question' => 'Berapakah Jumlah 1 + 1 ?',
            'question_desc' => '',
            'image' => '',
            'correct_answer' => '2'
        ]);

        QuestionOption::create([
            'question_id' => $question2->id,
            'type' => 'text',
            'value' => '3'
        ]);
        QuestionOption::create([
            'question_id' => $question2->id,
            'type' => 'text',
            'value' => '2'
        ]);
        QuestionOption::create([
            'question_id' => $question2->id,
            'type' => 'text',
            'value' => '8'
        ]);
        QuestionOption::create([
            'question_id' => $question2->id,
            'type' => 'text',
            'value' => '10'
        ]);

        // Motorik-3 Question
        $question3 = Question::create([
            'level' => 'motorik-3',
            'question' => 'M A K _ N.',
            'question_desc' => 'huruf apa yang hilang ?',
            'image' => '',
            'correct_answer' => 'A'
        ]);

        QuestionOption::create([
            'question_id' => $question3->id,
            'type' => 'text',
            'value' => 'C'
        ]);
        QuestionOption::create([
            'question_id' => $question3->id,
            'type' => 'text',
            'value' => 'K'
        ]);
        QuestionOption::create([
            'question_id' => $question3->id,
            'type' => 'text',
            'value' => 'I'
        ]);
        QuestionOption::create([
            'question_id' => $question3->id,
            'type' => 'text',
            'value' => 'A'
        ]);

        // Motorik-4 Question
        $question4 = Question::create([
            'level' => 'motorik-4',
            'question' => '',
            'question_desc' => 'Bentuk apakah gambar tersebut!',
            'image' => 'shapeQuest.png',
            'correct_answer' => 'shape'
        ]);

        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'shape',
            'image' => 'shape.png'
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'ellipse',
            'image' => 'ellipse.png'
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'polygon',
            'image' => 'polygon.png'
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'star',
            'image' => 'star.png'
        ]);
    }
}
