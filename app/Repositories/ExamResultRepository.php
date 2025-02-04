<?php

namespace App\Repositories;

use App\Models\ExamResult;

class ExamResultRepository
{
    public function getResults()
    {
        return ExamResult::with('exam', 'user')->get();
    }

    public function getResult($user_id, $exam_id)
    {
        return ExamResult::where('user_id', $user_id)->where('exam_id', $exam_id)->first();
    }

    public function getById($id)
    {
        return ExamResult::with('exam', 'sectionScores.partScores', 'user')->find($id);
    }

    public function create($data)
    {
        return ExamResult::create($data);
    }

    public function update($id, $data)
    {
        $examResult = ExamResult::find($id);
        $examResult->update($data);
        return $examResult;
    }

    public function delete($id)
    {
        $examResult = ExamResult::find($id);
        $examResult->delete();
    }

    public function getUncheckedExams()
    {
        return ExamResult::where('status', 'pending')->get();
    }

    public function completedExams()
    {
        return ExamResult::where('status', 'completed')->paginate(100);
    }
}
