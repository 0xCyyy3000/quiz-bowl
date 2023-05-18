<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mode extends Model
{
    use HasFactory;

    protected $fillable = [
        'mode', 'timer'
    ];

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
