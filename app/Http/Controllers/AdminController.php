<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        if ($request->username === 'admin' && $request->password === 'admin123') {
            $user = Auth::user();
            if ($user) {
                Auth::logout();
            }
            
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }
        
        $questions = Question::with('options')->get();
        return view('admin.dashboard', compact('questions'));
    }

    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('admin.login');
    }

    // Questions Management Methods
    public function createQuestion()
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }
        return view('admin.questions.form');
    }

    public function storeQuestion(Request $request)
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'question_desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'correct_answer' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*.type' => 'required|in:text,image',
            'options.*.value' => 'required|string',
            'options.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Create question
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('questions', 'public');
                $validated['image'] = $path;
            }

            $question = Question::create([
                'level' => $validated['level'],
                'question' => $validated['question'],
                'question_desc' => $validated['question_desc'],
                'image' => $validated['image'] ?? null,
                'correct_answer' => $validated['correct_answer']
            ]);

            // Create options
            foreach ($validated['options'] as $optionData) {
                $option = new QuestionOption([
                    'type' => $optionData['type'],
                    'value' => $optionData['value']
                ]);

                if (isset($optionData['image']) && $request->hasFile("options.{$loop->index}.image")) {
                    $path = $request->file("options.{$loop->index}.image")->store('options', 'public');
                    $option->image = $path;
                }

                $question->options()->save($option);
            }

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Question created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating question: ' . $e->getMessage());
        }
    }

    public function editQuestion(Question $question)
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }
        $question->load('options');
        return view('admin.questions.form', compact('question'));
    }

    public function updateQuestion(Request $request, Question $question)
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'question_desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'correct_answer' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*.type' => 'required|in:text,image',
            'options.*.value' => 'required|string',
            'options.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Update question
            if ($request->hasFile('image')) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }
                $path = $request->file('image')->store('questions', 'public');
                $validated['image'] = $path;
            }

            $question->update([
                'level' => $validated['level'],
                'question' => $validated['question'],
                'question_desc' => $validated['question_desc'],
                'image' => $validated['image'] ?? $question->image,
                'correct_answer' => $validated['correct_answer']
            ]);

            // Update options
            $question->options()->delete(); // Remove old options
            foreach ($validated['options'] as $index => $optionData) {
                $option = new QuestionOption([
                    'type' => $optionData['type'],
                    'value' => $optionData['value']
                ]);

                if (isset($optionData['image']) && $request->hasFile("options.{$index}.image")) {
                    $path = $request->file("options.{$index}.image")->store('options', 'public');
                    $option->image = $path;
                }

                $question->options()->save($option);
            }

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Question updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error updating question: ' . $e->getMessage());
        }
    }

    public function destroyQuestion(Question $question)
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login');
        }

        try {
            DB::beginTransaction();

            // Delete question image
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }

            // Delete option images
            foreach ($question->options as $option) {
                if ($option->image) {
                    Storage::disk('public')->delete($option->image);
                }
            }

            $question->delete(); // This will also delete related options due to cascade

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Question deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting question: ' . $e->getMessage());
        }
    }
} 