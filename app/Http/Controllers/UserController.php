<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\ExamRepository;
use App\Repositories\ExamResultRepository;
use App\Repositories\PartRepository;
use App\Repositories\PartScoreRepository;
use App\Repositories\SectionRepository;
use App\Repositories\SectionScoreRepository;
use App\Repositories\UserAnswerRepository;
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
        protected PartRepository $partRepository,
        protected SectionScoreRepository $sectionScoreRepository,
        protected UserAnswerRepository $userAnswerRepository
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
            return redirect()->route('user.section.show', ['id' => $exam->sections->first()->id]);
        }
        else{
            return back()->with('login_error', 1);
        }
    }

    public function logout(){
        session()->flush();
        return redirect()->route('user.login');
    }

    public function show_section($section_id){
        $exam_result = $this->examResultRepository->getById(session('exam_result_id'));
        $section = $this->sectionRepository->getById($section_id);
        $section_score = $this->sectionScoreRepository->getSectionScore($section_id, session('exam_result_id'));
        if(!$section_score){
            $section_score = $this->sectionScoreRepository->create([
                'section_id' => $section_id,
                'exam_result_id' => session('exam_result_id'),
                'score' => 0,
                'type' => $section->type,
                'percent' => 0,
            ]);
        }
        $solved_parts_ids = $this->partScoreRepository->getSolvedPartsIds($section_score->id);
        return view('user.home', ['exam_result' => $exam_result, 'section' => $section, 'solved_parts_ids' => $solved_parts_ids]);
    }

    public function show_section_by_type($exam_id, $type){
        $section = $this->sectionRepository->getByType($exam_id, $type);
        return redirect()->route('user.section.show', ['id' => $section->id]);
    }

    public function play_part($id){
        $part = $this->partRepository->getById($id);
        if($part->type == 'quiz'){
            return view('user.parts.quiz', ['part' => $part]);
        }
        elseif($part->type == 'listening_audio'){
            return view('user.parts.audio', ['part' => $part]);
        }
        elseif($part->type == 'writing'){
            return view('user.parts.writing', ['part' => $part]);
        }
        elseif($part->type == 'speaking'){
            return view('user.parts.speaking', ['part' => $part]);
        }
    }

    public function check_quiz(Request $request){
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|boolean',
            'quiz_count' => 'required|integer',
            'part_id' => 'required|integer',
            'exam_result_id' => 'required|integer',
        ]);
        $partScore = $this->partScoreRepository->getById($request->input('part_id'));
        if($partScore){
            return redirect()->route('user.section.show', ['id' => $request->input('section_id')])->with('unsuccessfully', 'Siz bu bo\'limni avval o\'tkazgansiz');
        }
        $answers = $request->input('answers');
        $score = 0;
        $section_score = $this->sectionScoreRepository->getSectionScore($request->input('section_id'), $request->input('exam_result_id'));
        foreach ($answers as $questionIndex => $isCorrect) {
            $score += $isCorrect;
        }
        $this->partScoreRepository->create([
            'part_id' => $request->input('part_id'),
            'exam_result_id' => $request->input('exam_result_id'),
            'score' => $score,
            'percent' => ($score / $request->input('quiz_count')) * 100,
            'section_score_id' => $section_score->id,
        ]);
        $part_scores = $this->partScoreRepository->getBySectionScoreId($section_score->id);
        $all_percent_sum = 0;
        foreach ($part_scores as $part_score){
            $all_percent_sum += $part_score->percent;
        }
        $new_section_score_percent = $all_percent_sum / count($part_scores);
        $section_score->score += $score;
        $section_score->percent = $new_section_score_percent;
        $section_score->save();
        return redirect()->route('user.section.show', ['id' => $request->input('section_id')]);
    }

    public function check_writing(Request $request){
        $request->validate([
            'answer' => 'required|string',
            'part_id' => 'required|integer',
            'exam_result_id' => 'required|integer',
            'question_id' => 'required|integer',
            'section_id' => 'required|integer',
        ]);

        $partScore = $this->partScoreRepository->getById($request->input('part_id'));
        if($partScore){
            return redirect()->route('user.section.show', ['id' => $request->input('section_id')])->with('unsuccessfully', 'Siz bu bo\'limni avval o\'tkazgansiz');
        }
        $section_score = $this->sectionScoreRepository->getSectionScore($request->input('section_id'), $request->input('exam_result_id'));

        $partScore = $this->partScoreRepository->create([
            'part_id' => $request->input('part_id'),
            'exam_result_id' => $request->input('exam_result_id'),
            'score' => 0,
            'percent' => 0,
            'status' => 'pending', // 'pending', 'checked', 'unchecked
            'section_score_id' => $section_score->id,
        ]);

        $this->userAnswerRepository->create([
            'part_score_id' => $partScore->id,
            'question_id' => $request->input('question_id'),
            'answer' => $request->input('answer'),
            'score' => 0,
            'status' => 'pending',
        ]);
        return redirect()->route('user.section.show', ['id' => $request->input('section_id')]);
    }

    public function check_speaking(Request $request)
    {
        $request->validate([
            'part_id' => 'required|integer',
            'exam_result_id' => 'required|integer',
            'section_id' => 'required|integer',
            'question_id' => 'required|array',
            'question_id.*' => 'required|integer',
        ]);

        $section_score = $this->sectionScoreRepository->getSectionScore($request->input('section_id'), $request->input('exam_result_id'));
        $partScore = $this->partScoreRepository->create([
            'part_id' => $request->input('part_id'),
            'exam_result_id' => $request->input('exam_result_id'),
            'score' => 0,
            'percent' => 0,
            'status' => 'pending', // 'pending', 'checked', 'unchecked
            'section_score_id' => $section_score->id,
        ]);

        foreach ($request->question_id as $questionId) {
            if ($request->has("audio_{$questionId}")) {
                $audioData = $request->input("audio_{$questionId}");
                $audioFileName = "answer_{$questionId}_" . time() . ".wav";
                $audioPath = public_path("records/{$audioFileName}");

                file_put_contents($audioPath, base64_decode(explode(",", $audioData)[1]));

                $this->userAnswerRepository->create([
                    'question_id' => $questionId,
                    'audio' => "$audioPath",
                    'score' => 0,
                    'status' => 'pending',
                    'part_score_id' => $partScore->id,
                    'answer' => $request->input('answer'),
                ]);
            }
        }

        return redirect()->route('user.section.show', ['id' => $request->input('section_id')]);
    }

}
