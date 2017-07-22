<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Auth;

class UserService
{

    private $userRepositry;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepositry = $userRepository;
    }

    public function create(array $data)
    {
        $user = $this->userRepositry->create($data);

        return $user;
    }

    public function resetPassword(User $user, $password) {
        $user = $this->userRepositry->resetPassword($user, $password);

        Auth::guard()->login($user);

        return $user;
    }
}