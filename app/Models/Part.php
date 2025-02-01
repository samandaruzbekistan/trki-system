<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'name', 'description', 'section_id', 'duration', 'type', 'audio', 'video_frame', 'max_score'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
