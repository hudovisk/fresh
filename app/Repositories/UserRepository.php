<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function create($data) {
        $data['password'] = bcrypt($data['password']);
        $data['uuid'] = Uuid::uuid();

        $user = (new User())->fill($data);
        $user->save();

        return $user;
    }

}