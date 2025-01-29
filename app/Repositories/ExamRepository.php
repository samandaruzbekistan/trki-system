<?php

namespace App\Repositories;

use App\Models\Exam;

class ExamRepository
{
    public function getById($id)
    {
        return Exam::with('sections')->find($id);
    }

    public function getExams()
    {
        return Exam::with('sections')->get();
    }

    public function create($data)
    {
        return Exam::create($data);
    }

    public function update($id, $data)
    {
        $exam = Exam::find($id);
        $exam->update($data);
        return $exam;
    }

    public function delete($id)
    {
        $exam = Exam::find($id);
        $exam->delete();
    }
}
