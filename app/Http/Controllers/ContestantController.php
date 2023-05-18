<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\RoundSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestantController extends Controller
{
    public function saveAnswer($request)
    {
        $question   = Question::find($request['question_id']);
        $user       = $request['auth_id'];

        if ($question->type_id == 1) {
            $choices = ['a', 'b', 'c', 'd'];
            $roundStatus =
                $request['answer'] != 'x_x*;^_^' and strtolower($question->correct_answer) == strtolower($choices[$request['answer']]) ? 1 : 0;
        } else {
            $roundStatus = strtolower($question->correct_answer) == strtolower($request['answer']) ? 1 : 0;
        }


        $question_no = RoundSummary::where('round', $question->mode_id)->latest()->first();
        if ($question_no)
            $question_no = $question_no->question_id == $question->id ? $question_no->question_no : $question_no->question_no + 1;
        else {
            $latest_summary = RoundSummary::latest()->first('question_no');
            $question_no = $latest_summary ? $latest_summary->question_no + 1 : 1;
        }

        // $round = 
        RoundSummary::create([
            'contestant'    => $user,
            'round'         => $question->mode_id,
            'question_no'   => $question_no,
            'question_id'   => $question->id,
            'round_status'  => $roundStatus
        ]);
        // dd(['mode' => $question->mode, 'status' => $roundStatus, 'new_round_id' => $round->id]);
    }
}
