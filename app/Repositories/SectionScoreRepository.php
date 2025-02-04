<?php

namespace App\Repositories;

use App\Models\SectionScore;

class SectionScoreRepository
{
    public function getSectionScore($section_id, $exam_result_id)
    {
        return SectionScore::where('section_id', $section_id)
            ->where('exam_result_id', $exam_result_id)
            ->first();
    }

    public function create($data)
    {
        return SectionScore::create($data);
    }

    public function getCheckedSection($exam_result_id)
    {
        return SectionScore::with('partScores')->where('exam_result_id', $exam_result_id)
            ->where('status', "checked")
            ->get();
    }

    public function getUnCheckedSection($exam_result_id)
    {
        return SectionScore::with('partScores')->where('exam_result_id', $exam_result_id)
            ->where('status', "pending")
            ->get();
    }

    public function update($id, $data)
    {
        $section_score = SectionScore::find($id);
        $section_score->update($data);
        return $section_score;
    }

    public function delete($id)
    {
        $section_score = SectionScore::find($id);
        $section_score->delete();
    }
}
