<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $user = $this->userService->create($request->all());

            return JsonResponseHelper::successResponse('Usuário criado com sucesso',
                fractal($user, new UserTransformer())->toArray(), 201);
        });
    }

}
