<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'type_id',
        'mode_id', 'question', 'choices', 'correct_answer', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mode()
    {
        return $this->belongsTo(Mode::class);
    }

    public function type()
    {
        return $this->belongsTo(QuestionType::class);
    }
}
