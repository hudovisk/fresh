<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateProfile(UpdateProfileRequest $request) {
        return DB::transaction(function () use ($request) {
            $data = $request->only(['name', 'email']);

            $user = $this->userService->update($request->user(), $data);

            return JsonResponseHelper::successResponse('Usuário atualizado com sucesso',
                fractal($user, new UserTransformer())->toArray(), 200);
        });
    }

}
