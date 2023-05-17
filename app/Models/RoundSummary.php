<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundSummary extends Model
{
    use HasFactory;
    protected $fillable = [
        'contestant', 'round', 'question_no', 'question_id', 'round_status'
    ];
}
