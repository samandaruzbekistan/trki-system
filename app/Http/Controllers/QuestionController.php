<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(protected QuestionRepository $questionRepository, protected AnswerRepository $answerRepository)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'part_id' => 'required|numeric|exists:parts,id',
            'question' => 'required|string',
            'type' => 'required|string',
            'duration' => 'nullable|numeric',
            'score' => 'nullable|numeric',
            'a_answer' => 'nullable|string',
            'b_answer' => 'nullable|string',
            'c_answer' => 'nullable|string',
            'd_answer' => 'nullable|string',
        ]);

        $question = $this->questionRepository->create($data);
        if ($request->a_answer){
            $this->answerRepository->create([
                'question_id' => $question->id,
                'answer' => $data['a_answer'],
                'is_correct' => 1
            ]);
        }
        if($request->b_answer){
            $this->answerRepository->create([
                'question_id' => $question->id,
                'answer' => $data['b_answer'],
                'is_correct' => 0
            ]);
        }
        if($request->c_answer){
            $this->answerRepository->create([
                'question_id' => $question->id,
                'answer' => $data['c_answer'],
                'is_correct' => 0
            ]);
        }
        if($request->d_answer){
            $this->answerRepository->create([
                'question_id' => $question->id,
                'answer' => $data['d_answer'],
                'is_correct' => 0
            ]);
        }
        return back()->with('successfully', "Savol muvaffaqiyatli yaratildi");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->questionRepository->delete($id);
        return back()->with('successfully', "Savol muvaffaqiyatli o'chirildi");
    }
}
