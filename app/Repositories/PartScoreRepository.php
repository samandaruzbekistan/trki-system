<?php

namespace App\Repositories;

use App\Models\PartScore;

class PartScoreRepository
{
    public function create($data)
    {
        return PartScore::create($data);
    }

    public function update($partScore, $data)
    {
        $partScore->update($data);
        return $partScore;
    }

    public function getSolvedPartsIds($section_score_id)
    {
        return PartScore::where('section_score_id', $section_score_id)
            ->pluck('part_id')
            ->toArray();
    }

    public function getUncheckedParts($section_score_id)
    {
        return PartScore::where('section_score_id', $section_score_id)
            ->where('status', 'pending')
            ->get();
    }

    public function getBySectionScoreId($section_score_id)
    {
        return PartScore::where('section_score_id', $section_score_id)
            ->get();
    }

    public function getById($id)
    {
        return PartScore::find($id);
    }

    public function delete($partScore)
    {
        $partScore->delete();
    }
}
