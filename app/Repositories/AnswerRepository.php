<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository
{
    public function getById($id)
    {
        return Answer::find($id);
    }

    public function create($data)
    {
        return Answer::create($data);
    }

    public function update($id, $data)
    {
        $answer = Answer::find($id);
        $answer->update($data);
        return $answer;
    }

    public function delete($id)
    {
        $answer = Answer::find($id);
        $answer->delete();
    }
}
