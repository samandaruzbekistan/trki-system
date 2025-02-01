<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_result_id',
        'part_id',
        'section_score_id',
        'score',
        'percent',
        'status'
    ];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function sectionScore()
    {
        return $this->belongsTo(SectionScore::class);
    }

    public function examResult()
    {
        return $this->belongsTo(ExamResult::class);
    }
}
