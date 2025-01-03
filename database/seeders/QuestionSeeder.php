<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // ...existing code...
        Question::create([
            'level' => 'motorik-1',
            'question' => 'Mana balon yang berwarna hijau?',
            // ...existing code...
            'image' => 'Ballon_green.png',
        ]);

        Question::create([
            'level' => 'motorik-1',
            'question' => 'Mana balon yang berwarna kuning?',
            // ...existing code...
            'image' => 'Ballon_yellow.png',
        ]);

        Question::create([
            'level' => 'motorik-2',
            'question' => 'Berapakah Jumlah 1 + 1 ?',
            // ...existing code...
            'image' => null,
        ]);
        // ...existing code...
    }
}
