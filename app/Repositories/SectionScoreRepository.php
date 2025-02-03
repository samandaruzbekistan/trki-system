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
