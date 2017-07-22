<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

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

    public function forgotPassword(ForgotPasswordRequest $request) {
        return DB::transaction(function () use ($request) {

            $response = Password::broker()->sendResetLink(
                $request->only('email')
            );

            return $response == Password::RESET_LINK_SENT
                ? JsonResponseHelper::successResponse('Email enviado com sucesso')
                : JsonResponseHelper::errorResponse(trans($response));
        });
    }

    public function resetPassword(ResetPasswordRequest $request) {
        return DB::transaction(function () use ($request) {
            $data = $request->all();

            $response = Password::broker()->reset($data, function ($user, $password) {
                $this->userService->resetPassword($user, $password);
            });

            return $response == Password::PASSWORD_RESET
                ? JsonResponseHelper::successResponse('Senha resetada com sucesso')
                : JsonResponseHelper::errorResponse(trans($response));
        });
    }

}
