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

    public function delete($partScore)
    {
        $partScore->delete();
    }
}
