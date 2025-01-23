<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class QuestionSeeder extends Seeder
{
    private function copyGameImage($imageName)
    {
        try {
            $sourcePath = database_path('seeders/images/' . $imageName);
            $destinationPath = public_path('asset/' . $imageName);
            
            // Create the destination directory if it doesn't exist
            if (!File::exists(public_path('asset'))) {
                File::makeDirectory(public_path('asset'), 0755, true);
            }
            
            // Check if source image exists
            if (!File::exists($sourcePath)) {
                Log::warning("Game image not found: {$imageName}");
                return null;
            }
            
            // Copy the image
            File::copy($sourcePath, $destinationPath);
            
            return $imageName;
        } catch (\Exception $e) {
            Log::error("Failed to copy game image {$imageName}: " . $e->getMessage());
            return null;
        }
    }

    private function copyQuestionImage($imageName)
    {
        try {
            $sourcePath = database_path('seeders/images/' . $imageName);
            
            // Check if source image exists
            if (!File::exists($sourcePath)) {
                Log::warning("Question image not found: {$imageName}");
                return null;
            }
            
            // Copy to storage/app/public
            Storage::disk('public')->put($imageName, File::get($sourcePath));
            
            return $imageName;
        } catch (\Exception $e) {
            Log::error("Failed to copy question image {$imageName}: " . $e->getMessage());
            return null;
        }
    }

    private function setupGameImages()
    {
        // Copy game-related images
        $gameImages = [
            'Motorik1.png',
            'Motorik2.png',
            'Motorik3.png',
            'Motorik4.png',
            'CheckBox.png',
            'FalseBox.png',
            'star.png',
            'shapeQuest.png'
        ];

        foreach ($gameImages as $image) {
            $this->copyGameImage($image);
        }
    }

    public function run()
    {
        // Clear existing images
        if (File::exists(public_path('asset'))) {
            File::cleanDirectory(public_path('asset'));
        }
        Storage::disk('public')->delete(Storage::disk('public')->allFiles());
        
        // Setup game images
        $this->setupGameImages();

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
            'image' => $this->copyQuestionImage('Ballon_yellow.png')
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'black',
            'image' => $this->copyQuestionImage('Ballon_brown.png')
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'green',
            'image' => $this->copyQuestionImage('Ballon_green.png')
        ]);
        QuestionOption::create([
            'question_id' => $question1->id,
            'type' => 'image',
            'value' => 'blue',
            'image' => $this->copyQuestionImage('Ballon_blue.png')
        ]);

        // Motorik-1 Question 2
        $question1b = Question::create([
            'level' => 'motorik-1',
            'question' => 'Jika warna merah dicampur dengan warna kuning, akan menghasilkan warna apa?',
            'question_desc' => '',
            'image' => '',
            'correct_answer' => 'Oranye'
        ]);

        QuestionOption::create([
            'question_id' => $question1b->id,
            'type' => 'text',
            'value' => 'Ungu'
        ]);
        QuestionOption::create([
            'question_id' => $question1b->id,
            'type' => 'text',
            'value' => 'Oranye'
        ]);
        QuestionOption::create([
            'question_id' => $question1b->id,
            'type' => 'text',
            'value' => 'Hijau'
        ]);
        QuestionOption::create([
            'question_id' => $question1b->id,
            'type' => 'text',
            'value' => 'Coklat'
        ]);

        // Motorik-1 Question 3
        $question1c = Question::create([
            'level' => 'motorik-1',
            'question' => 'Warna apakah balon ini?',
            'question_desc' => '',
            'image' => $this->copyQuestionImage('purple_balloon.webp'),
            'correct_answer' => 'Ungu'
        ]);

        QuestionOption::create([
            'question_id' => $question1c->id,
            'type' => 'text',
            'value' => 'Merah'
        ]);
        QuestionOption::create([
            'question_id' => $question1c->id,
            'type' => 'text',
            'value' => 'Ungu'
        ]);
        QuestionOption::create([
            'question_id' => $question1c->id,
            'type' => 'text',
            'value' => 'Hijau'
        ]);
        QuestionOption::create([
            'question_id' => $question1c->id,
            'type' => 'text',
            'value' => 'Oranye'
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
            'image' => $this->copyQuestionImage('shape.png')
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'ellipse',
            'image' => $this->copyQuestionImage('ellipse.png')
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'polygon',
            'image' => $this->copyQuestionImage('polygon.png')
        ]);
        QuestionOption::create([
            'question_id' => $question4->id,
            'type' => 'image',
            'value' => 'star',
            'image' => $this->copyQuestionImage('star.png')
        ]);
    }
}
