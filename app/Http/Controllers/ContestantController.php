<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\RoundSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestantController extends Controller
{
    public function saveAnswer(Request $request)
    {
        $question   = Question::find($request->question_id);
        // $user       = Auth::user()->id;

        if ($question->mode == 1) {
            $choices = ['a', 'b', 'c', 'd'];
            $roundStatus = strtolower($question->correct_answer) == strtolower($choices[$request->answer]) ? 1 : 0;
        } else if ($question->mode == 2) {
            $roundStatus = strtolower($question->correct_answer) == strtolower($request->answer) ? 1 : 0;
        }

        $question_no = RoundSummary::where('round', $question->mode)->latest()->first();

        $round = RoundSummary::create([
            'contestant'    => 1,
            'round'         => $question->mode,
            'question_no'   => $question_no ? $question_no->question_no + 1 : 1,
            'question_id'   => $question->id,
            'round_status'  => $roundStatus
        ]);
        dd([
            $request->all(),
            'mode' => $question->mode, 'status' => $roundStatus, 'new_round_id' => $round->id
        ]);
    }
}
