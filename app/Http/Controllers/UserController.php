<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\ExamRepository;
use App\Repositories\ExamResultRepository;
use App\Repositories\PartRepository;
use App\Repositories\PartScoreRepository;
use App\Repositories\SectionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected UserRepository $userRepository,
        protected ExamRepository $examRepository,
        protected ExamResultRepository $examResultRepository,
        protected SectionRepository $sectionRepository,
        protected PartScoreRepository $partScoreRepository,
        protected PartRepository $partRepository
    )
    {
    }

    public function auth(LoginRequest $request){
        $user = $this->userRepository->getUser($request->username);
        if (!$user){
            return back()->with('login_error', 1);
        }
        if (Hash::check($request->input('password'), $user->password)) {
            session()->flush();
            $exam = $this->examRepository->getActiveExam();
            $exam_result = $this->examResultRepository->getResult($user->id, $exam->id);
            if($exam_result){
                session()->put('exam_result_id',$exam_result->id);
            }
            else{
                $exam_result = $this->examResultRepository->create([
                    'user_id' => $user->id,
                    'exam_id' => $exam->id,
                    'status' => 'pending',
                ]);
                session()->put('exam_result_id',$exam_result->id);
            }
            session()->put('exam_id',$exam->id);
            session()->put('exam_name',$exam->name);
            session()->put('user',1);
            session()->put('name',$user->full_name);
            session()->put('id',$user->id);
            session()->put('username',$user->username);
            return redirect()->route('user.home');
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('user.login');
    }

    public function home(){
        $exam = $this->examRepository->getById(session('exam_id'));
        $section = $this->sectionRepository->getById($exam->sections->first()->id);
        $exam_result = $this->examResultRepository->getById(session('exam_result_id'));
        return view('user.home', ['exam' => $exam, 'exam_result' => $exam_result, 'section' => $section]);
    }

    public function play_part($id){
        $part = $this->partRepository->getById($id);
        return view('user.parts.quiz', ['part' => $part]);
//        if($part->type == 'quiz'){
//            return view('user.parts.quiz', ['part' => $part]);
//        }
//        else{
//            return view('user.playvideo', ['part' => $part]);
//        }
    }
}
