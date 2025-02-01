<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_result_id',
        'score',
        'percent',
        'section_id',
    ];

    public function partScores()
    {
        return $this->hasMany(PartScore::class);
    }

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }
}
