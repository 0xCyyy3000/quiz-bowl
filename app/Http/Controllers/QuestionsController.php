<?php

namespace App\Http\Controllers;
use App\Models\Questions;


use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    //
    public function index()
    { 
        $data = Questions::all();
        return view('question', ['questions' => $data]);
    }
    public function store(Request $request)
    {

        Questions::create([
            'questions' => $request->input('questions')
        ]);

        return redirect('/questions');
    }

    public function update(Request $request, $id)
    {
        $questions = Questions::findOrFail($id);
        $questions->questions = $request->input('questions');
        $questions->save();

        return redirect('/questions');
    }
    
    public function destroy($id)
    {
        $question = Questions::findOrFail($id);
        $question->delete();

        return redirect('/questions');
    }
}
