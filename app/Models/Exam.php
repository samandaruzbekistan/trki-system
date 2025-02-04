<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'level_id',
    ];

    public function sections(){
        return $this->hasMany(Section::class);
    }

    public function level(){
        return $this->belongsTo(ExamLevel::class, 'level_id', 'id');
    }
}
