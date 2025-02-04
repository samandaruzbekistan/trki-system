<?php

namespace App\Repositories;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherRepository
{
    public function getTeacher($username){
        return Teacher::where('username', $username)->first();
    }

    public function update_password($password){
        Teacher::where('id', session('id'))->update(['password' => Hash::make($password)]);
    }
}
