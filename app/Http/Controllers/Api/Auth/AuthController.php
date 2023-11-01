<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Repository\IUsersRepository;
use App\Repositories\UsersGroupsRepository;

class AuthController extends Controller
{
    public function __construct(
        protected IUsersRepository $usersRepository,
        protected UsersGroupsRepository $usersGroupsRepository
    ) {
    }
    public function login(Request $request)
    {
        $user = $this->usersRepository->getByEmail($request->email);

        $isValidPassword = $this->usersRepository->checkUserPasswordByEmail($request->email, $request->password);
        if (!$user || !$isValidPassword) {
            return response()->json([
                'message' => 'Credenciais inválidas!'
            ], 401);
        };

        $token = $this->usersRepository->createTokenByUserEmail($request->email, $request->device_name);
        $user_group = $this->usersGroupsRepository->getById($user['user_group_id_FK']);

        return response()->json([
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],

            'token' => $token,

            'type' => $user_group->name,
        ]);
    }
}
