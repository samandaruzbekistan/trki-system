<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'description', 'exam_id'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }
}
