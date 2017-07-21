<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Faker\Provider\Uuid;

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
}