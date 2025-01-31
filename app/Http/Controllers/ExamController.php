<?php

namespace App\Http\Controllers;

use App\Repositories\ExamRepository;
use App\Repositories\SectionRepository;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(protected ExamRepository $examRepository, protected SectionRepository $sectionRepository)
    {
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);
        $exam = $this->examRepository->create($request->all());
        $this->sectionRepository->create(['name' => 'Лексика. Грамматика', 'exam_id' => $exam->id, 'type' => 'quiz', 'description' => '']);
        $this->sectionRepository->create(['name' => 'Чтение', 'exam_id' => $exam->id, 'type' => 'reading', 'description' => '']);
        $this->sectionRepository->create(['name' => 'Аудирование', 'exam_id' => $exam->id, 'type' => 'listening', 'description' => '']);
        $this->sectionRepository->create(['name' => 'Письмо', 'exam_id' => $exam->id, 'type' => 'writing', 'description' => '']);
        $this->sectionRepository->create(['name' => 'Говорение', 'exam_id' => $exam->id, 'type' => 'speaking', 'description' => '']);
        return back()->with('successfully', "Imtixon muvaffaqiyatli yaratildi");
    }

    public function index($id)
    {
        $exam = $this->examRepository->getById($id);
        return view('admin.exam', ['exam' => $exam]);
    }
}
