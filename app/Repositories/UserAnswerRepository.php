<?php

namespace App\Repositories;

use App\Models\UserAnswer;

class UserAnswerRepository
{
    public function getAnswer($part_score_id, $question_id)
    {
        return UserAnswer::where('part_score_id', $part_score_id)
            ->where('question_id', $question_id)
            ->first();
    }

    public function get($id)
    {
        return UserAnswer::find($id);
    }

    public function create($data)
    {
        return UserAnswer::create($data);
    }

    public function update($id, $data)
    {
        $user_answer = UserAnswer::find($id);
        $user_answer->update($data);
        return $user_answer;
    }

    public function delete($id)
    {
        $user_answer = UserAnswer::find($id);
        $user_answer->delete();
    }

    public function getByPartScore($part_id)
    {
        return UserAnswer::where('part_score_id', $part_id)->get();
    }
}
