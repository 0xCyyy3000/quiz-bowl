<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\RoundSummary;
use Illuminate\Http\Request;

class RoundSummaryController extends Controller
{
    public function index(Request $request)
    {
        // $round_summary = RoundSummary::get();
        // dd($round_summary);
        $summary = array();
        $contestants = Contestant::get();
        foreach ($contestants as $contestant) {
            $contestant->score += RoundSummary::where('contestant', $contestant->id)->sum('round_status');
            array_push(
                $summary,
                [
                    'name'  => $contestant->name,
                    'score' => $contestant->score,
                ]
            );
        }

        return response()->json(['summary' => $summary]);
    }
}
