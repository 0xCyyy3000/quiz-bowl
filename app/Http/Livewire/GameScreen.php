<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Question;

class GameScreen extends Component
{
    public $question, $ranking;
    protected $listen = ['showQuestion', 'showRanking'];

    public function render()
    {
        return view('livewire.game-screen');
    }

    public function showQuestion(Question $question)
    {
        $this->question = 'hello';
    }

    public function showRanking()
    {
        $this->ranking = 'Ranking is displayed';
    }
}
