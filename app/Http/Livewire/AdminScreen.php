<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Question;

class AdminScreen extends Component
{
    public $question;

    public function render()
    {
        return view('livewire.admin-screen');
    }
}
