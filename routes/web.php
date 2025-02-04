<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/admin', 'admin.login')->name('admin.login');
Route::view('/login', 'user.login')->name('user.login');

Route::prefix('user')->group(function () {
    Route::post('auth', [UserController::class, 'auth'])->name('user.auth');
    Route::middleware(['user_auth'])->group(function () {
        Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
        Route::get('show-section/{id}', [UserController::class, 'show_section'])->name('user.section.show');
        Route::get('show-section-by-type/{exam_id}/{type}', [UserController::class, 'show_section_by_type'])->name('user.section.show.type');
        Route::get('play-part/{id}', [UserController::class, 'play_part'])->name('user.part.play');

        Route::post('check-quiz', [UserController::class, 'check_quiz'])->name('user.quiz.check');
        Route::post('check-writing', [UserController::class, 'check_writing'])->name('user.writing.check');
        Route::post('check-speaking', [UserController::class, 'check_speaking'])->name('user.speaking.check');

    });
});

Route::prefix('admin')->group(function () {
    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');
    Route::middleware(['admin_auth'])->group(function () {
        Route::get('home', [AdminController::class, 'home'])->name('admin.home');
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::post('update',[AdminController::class,'update'])->name('admin.update');

//        Exams control
        Route::get('exam/{id}',[ExamController::class,'index'])->name('admin.exam');
        Route::post('exam',[ExamController::class,'create'])->name('admin.exam.create');
        Route::post('exam/{id}',[ExamController::class,'exam_update'])->name('admin.exam.update');
        Route::get('exam/delete/{id}',[ExamController::class,'exam_delete'])->name('admin.exam.delete');

//        Sections control
        Route::get('section/{id}',[SectionController::class,'index'])->name('admin.section');
        Route::get('section/{type}', [SectionController::class, 'get_by_type'])->name('admin.section.type');

//        Parts control
        Route::get('part/{id}',[PartController::class,'index'])->name('admin.part');
        Route::post('part',[PartController::class,'create'])->name('admin.part.create');

//        Questions control
        Route::get('question/{id}',[QuestionController::class,'index'])->name('admin.question');
        Route::post('question',[QuestionController::class,'create'])->name('admin.question.create');
        Route::get('delete-question/{id}',[QuestionController::class,'destroy'])->name('admin.question.delete');

//        Users control
        Route::get('users',[AdminController::class,'users'])->name('admin.users');
        Route::post('users',[AdminController::class,'user_create'])->name('admin.users.create');
    });
});
