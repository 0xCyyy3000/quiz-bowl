<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\RoundSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
                    'name'  => $contestant->user->name,
                    'score' => $contestant->score,
                ]
            );
        }
        // Setting up the Trigger
        isset($request->action) ? '' : File::put(public_path('' . 'trigger.json'), json_encode(['value' => 'summary'], JSON_PRETTY_PRINT));

        // Soring the Summary Score
        usort($summary, fn ($a, $b) => $b['score'] <=> $a['score']);
        File::put(public_path('' . 'ranking.json'), json_encode($summary, JSON_PRETTY_PRINT));
        return response()->json($summary);
    }
}
