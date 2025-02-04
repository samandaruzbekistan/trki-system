<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\ExamRepository;
use App\Repositories\ExamResultRepository;
use App\Repositories\SectionScoreRepository;
use App\Repositories\TeacherRepository;
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
}
