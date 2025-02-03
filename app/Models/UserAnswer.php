<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_score_id',
        'question_id',
        'answer',
        'score',
        'audio',
        'status',
    ];

    public function part_score()
    {
        return $this->belongsTo(PartScore::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
