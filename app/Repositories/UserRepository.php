<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUser($username)
    {
        return User::where('username', $username)->first();
    }

    public function create($data)
    {
        return User::create($data);
    }

    public function get_all()
    {
        return User::paginate(100);
    }

    public function update($id, $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
    }
}
