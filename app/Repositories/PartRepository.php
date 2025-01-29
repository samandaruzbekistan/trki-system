<?php

namespace App\Repositories;

use App\Models\Part;

class PartRepository
{
    public function getById($id)
    {
        return Part::with('questions')->find($id);
    }

    public function create($data)
    {
        return Part::create($data);
    }

    public function update($id, $data)
    {
        $part = Part::find($id);
        $part->update($data);
        return $part;
    }

    public function delete($id)
    {
        $part = Part::find($id);
        $part->delete();
    }
}
