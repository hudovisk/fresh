<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserRepository
{

    public function create($data) {
        $data['password'] = bcrypt($data['password']);
        $data['uuid'] = Uuid::uuid1();

        $user = (new User())->fill($data);
        $user->save();

        return $user;
    }

    public function resetPassword(User $user, $password) {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        return $user;
    }

    public function update(User $user, $data) {
        $user->fill($data)->save();

        return $user;
    }

}