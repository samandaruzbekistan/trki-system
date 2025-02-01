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
        Route::get('home', [UserController::class, 'home'])->name('user.home');
        Route::get('play-part/{id}', [UserController::class, 'play_part'])->name('user.part.play');

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

//        Users control
        Route::get('users',[AdminController::class,'users'])->name('admin.users');
        Route::post('users',[AdminController::class,'user_create'])->name('admin.users.create');
    });
});
