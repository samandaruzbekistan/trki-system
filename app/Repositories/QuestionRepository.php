<?php

namespace App\Repositories;

use App\Models\Answer;
use App\Models\Question;

class QuestionRepository
{
    public function getById($id)
    {
        return Question::with('answers')->find($id);
    }

    public function create($data)
    {
        return Question::create($data);
    }

    public function update($id, $data)
    {
        $question = Question::find($id);
        $question->update($data);
        return $question;
    }

    public function delete($id)
    {
        Answer::where('question_id', $id)->delete();
        $question = Question::find($id);
        $question->delete();
    }
}
