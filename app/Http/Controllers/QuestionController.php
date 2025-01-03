<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return view('parent.index', compact('questions'));
    }

    public function create()
    {
        return view('parent.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'question_desc' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $data = $request->only(['level', 'question', 'question_desc']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        Question::create($data);

        return redirect()->route('parent.manage')->with('success', 'Question created successfully.');
    }

    public function edit($id)
    {
        $question = Question::findOrFail($id);
        return view('parent.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level' => 'required|string|max:255',
            'question' => 'required|string',
            'question_desc' => 'nullable|string',
            'image' => 'nullable|image',
        ]);

        $question = Question::findOrFail($id);
        $data = $request->only(['level', 'question', 'question_desc']);
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('questions', 'public');
        }

        $question->update($data);

        return redirect()->route('parent.manage')->with('success', 'Question updated successfully.');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('parent.manage')->with('success', 'Question deleted successfully.');
    }
}