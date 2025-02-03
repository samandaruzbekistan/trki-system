<?php

namespace App\Repositories;

use App\Models\Section;

class SectionRepository
{
    public function getById($id)
    {
        return Section::with('parts.questions.answers')->find($id);
    }

    public function create($data)
    {
        return Section::create($data);
    }

    public function update($id, $data)
    {
        $section = Section::find($id);
        $section->update($data);
        return $section;
    }

    public function delete($id)
    {
        $section = Section::find($id);
        $section->delete();
    }

    public function getByType($exam_id, $type)
    {
        return Section::where('exam_id', $exam_id)
            ->where('type', $type)
            ->first();
    }
}
