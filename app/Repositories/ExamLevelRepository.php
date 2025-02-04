<?php

namespace App\Repositories;

use App\Models\ExamLevel;

class ExamLevelRepository
{
    public function getLevels()
    {
        return ExamLevel::all();
    }

    public function getLevel($id)
    {
        return ExamLevel::find($id);
    }

    public function create($data)
    {
        return ExamLevel::create($data);
    }

    public function update($id, $data)
    {
        $examLevel = ExamLevel::find($id);
        $examLevel->update($data);
        return $examLevel;
    }

    public function delete($id)
    {
        $examLevel = ExamLevel::find($id);
        $examLevel->delete();
    }
}
