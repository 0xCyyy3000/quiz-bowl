<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        // Setting up the Trigger
        switch ($request->action) {
            case 'setLiveQuestion':
                File::put(public_path('' . 'data.json'), json_encode(
                    [
                        'type'      => $request->type,
                        'question'  => $request->question,
                        'choices'   => json_decode($request->choices),
                        'answer'    => $request->answer,
                        'timer'     => $this->getTimer($request->mode)
                    ],
                    JSON_PRETTY_PRINT
                ));

                File::put(public_path('' . 'trigger.json'), json_encode(
                    ['value' => 'QID_' . $request->id],
                    JSON_PRETTY_PRINT
                ));

                Question::where('id', $request->id)->update(['status' => 0]);
                break;

            case 'time':
                File::put(public_path('' . 'trigger.json'), json_encode(
                    ['value' => 'time'],
                    JSON_PRETTY_PRINT
                ));

                $contestant = new ContestantController();
                $contestant->saveAnswer([
                    'question_id' => $request->question_id,
                    'answer'      => $request->answer,
                    'auth_id'     => $request->auth_id
                ]);

                break;
        }
        return response()->json(['status' => 200]);
    }

    public function getTimer($mode)
    {
        if ($mode == 1) return 30;
        else if ($mode == 2) return 60;
        else return 90;
    }

    public function getQuestions()
    {
    }

    public function getRandom(Request $request)
    {
        $question = Question::where('status', 1)->where('mode_id', $request->mode)->inRandomOrder()->first();
        $question->choices = json_decode($question->choices);
        return response()->json([
            'question'      => $question,
            'categories'    => Category::get(['id', 'category'])
        ]);
    }

    public function select(Request $request)
    {
        return view(
            'quiz.select',
            [
                'question'      => Question::find($request->id),
                'categories'    => Category::get(['id', 'category']),
                'modes'         => Mode::get(['id', 'mode']),
                'types'          => QuestionType::get(['id', 'type'])
            ]
        );
    }

    public function update(Request $request)
    {
        $request->validate([
            'type'           => 'required',
            'category'       => 'required',
            'mode'           => 'required',
            'choices'        => 'required',
            'question'       => 'required',
            'status'         => 'required'
        ]);

        $choices = json_encode(['']);

        if ($request->type == 1) {
            $request->validate(['mul_correct_answer' => 'required']);
            $choices = json_encode([
                'a' => $request->choices[0],
                'b' => $request->choices[1],
                'c' => $request->choices[2],
                'd' => $request->choices[3],
            ]);
            $answer = $request->mul_correct_answer;
        } else
            $request->validate(['correct_answer' => 'required']);


        Question::where('id', $request->id)->update([
            'category_id'       => $request->category,
            'type_id'           => $request->type,
            'mode_id'           => $request->mode,
            'choices'           => $choices,
            'question'          => $request->question,
            'correct_answer'    => isset($answer) ? $answer : $request->correct_answer,
            'status'            => $request->status
        ]);

        return back();
    }

    public function create()
    {
        return view('quiz.create', [
            'id'            => Question::latest('id')->first('id')->id + 1,
            'categories'    => Category::get(['id', 'category']),
            'modes'         => Mode::get(['id', 'mode']),
            'types'         => QuestionType::get(['id', 'type'])
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'           => 'required',
            'category'       => 'required',
            'mode'           => 'required',
            'question'       => 'required'
        ]);

        $fields = [
            'category_id'   => $request->category,
            'type_id'       => $request->type,
            'mode_id'       => $request->mode,
            'question'      => $request->question,
        ];

        if ($request->type == 1) {
            $request->validate([
                'choices'               => 'required',
                'mul_correct_answer'    => 'required',
            ]);
            $fields['correct_answer'] = $request->mul_correct_answer;
            $fields['choices']          = json_encode([
                'a' => $request->choices[0],
                'b' => $request->choices[1],
                'c' => $request->choices[2],
                'd' => $request->choices[3],
            ]);
        } else {
            $request->validate(['correct_answer' => 'required']);
            $fields['correct_answer'] = $request->correct_answer;
            $fields['choices'] = json_encode(['']);
        }

        Question::create($fields);
        return redirect(route('quiz.manage'));
    }
}
