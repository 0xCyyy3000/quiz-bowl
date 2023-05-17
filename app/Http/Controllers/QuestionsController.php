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

    public function update(Request $request)
    {

        // return dd($request);
       $update=[
        'id' =>$request->id,
        'questions' =>$request->questions,
       ];

       Questions::where('id', $request->id)->update($update);
    //    return dd($update);
        return redirect('/questions');
    }
    
    public function destroy($id)
    {
        $question = Questions::findOrFail($id);
        $question->delete();

        return redirect('/questions');
    }
}
