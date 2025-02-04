<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\ExamRepository;
use App\Repositories\ExamResultRepository;
use App\Repositories\PartScoreRepository;
use App\Repositories\SectionScoreRepository;
use App\Repositories\TeacherRepository;
use App\Repositories\UserAnswerRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function __construct(
        protected ExamRepository $examRepository,
        protected ExamResultRepository $examResultRepository,
        protected UserRepository $userRepository,
        protected TeacherRepository $teacherRepository,
        protected SectionScoreRepository $sectionScoreRepository,
        protected UserAnswerRepository $userAnswerRepository,
        protected PartScoreRepository $partScoreRepository
    )
    {
    }

    public function auth(LoginRequest $request){
        $admin = $this->teacherRepository->getTeacher($request->username);
        if (!$admin){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $admin->password)) {
            session()->flush();
            session()->put('teacher',1);
            session()->put('name',$admin->name);
            session()->put('id',$admin->id);
            session()->put('username',$admin->username);
            return redirect()->route('teacher.results');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('teacher.login');
    }

    public function teacher_home(){
        $completed_exams = $this->examResultRepository->completedExams();
        return view('teacher.home', ['completed_exams' => $completed_exams]);
    }

    public function pending_exams(){
        $pending_exams = $this->examResultRepository->getUncheckedExams();
        return view('teacher.pending_exams', ['pending_exams' => $pending_exams]);
    }

    public function show_result($result_id){
        $result = $this->examResultRepository->getById($result_id);
        $checked = $this->sectionScoreRepository->getCheckedSection($result_id);
        $pending = $this->sectionScoreRepository->getUnCheckedSection($result_id);
        return view('teacher.show_result', ['result' => $result, 'checked' => $checked, 'pending' => $pending]);
    }

    public function show_unchecked_part($id){
        $user_answers = $this->userAnswerRepository->getByPartScore($id);
        return view('teacher.check_part', ['user_answers' => $user_answers, 'part_score_id' => $id]);
    }

    public function check_part(Request $request){
        $scores = $request->input('scores');
        $part_score_id = $request->input('part_score_id');
        $sum_score = 0;
        foreach ($scores as $userAnswerId => $score) {
            $userAnswer = $this->userAnswerRepository->get($userAnswerId);
            $userAnswer->score = $score;
            $userAnswer->status = "checked";
            $userAnswer->save();
            $sum_score += $score;
        }
        $part_score = $this->partScoreRepository->getById($part_score_id);
        $part_score->score = $sum_score;
        $part_score->percent = ($sum_score / $part_score->part->max_score) * 100;
        $part_score->status = "checked";
        $part_score->save();
        $unchecked_parts = $this->partScoreRepository->getUncheckedParts($part_score->section_score_id);
        $section_score = $this->sectionScoreRepository->getById($part_score->section_score_id);
        $section_score->score += $sum_score;
        if(count($unchecked_parts) == 0){
            $section_score->status = "checked";
        }
        $section_score->save();
        return redirect()->route('teacher.exams.show', ['result_id' => $section_score->exam_result_id])->with('successfully', 'Part checked successfully');
    }
}
