<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'question',
        'score',
        'type',
        'file_url',
        'duration'
    ];

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
