<?php

namespace App\Http\Controllers;

use App\Repositories\ExamRepository;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(protected ExamRepository $examRepository)
    {
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);
        $this->examRepository->create($request->all());
        return back()->with('successfully', "Imtixon muvaffaqiyatli yaratildi");
    }
}
