<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Repository\IUsersRepository;
use App\Interfaces\Repository\IUserGroupRepository;
use App\Enums\UsersGroupsEnum;
use App\DTO\Users\UserUpdateDTO;

class UserController extends Controller
{


    public function __construct(
        protected IUsersRepository $usersRepository,
        protected IUserGroupRepository $userGroupRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        $offset = $page <= 1 ? 0 : $page * $limit;

        // TODO: check user group if is have permission to filter user group or not
        $user_id = $request->user()->id;
        $user_group_id = $request->user()->user_group_id_FK;

        $user_group = $this->userGroupRepository->getById($user_group_id);

        $users = $this->usersRepository->getAll(null, $offset, $limit);
        $total_of_pages = ceil($this->usersRepository->getAllCount(null) / $limit);

        return response()->json([
            'data' => $users,
            'page' => $page,
            'items_per_page' => $limit,
            'total_of_pages' => $total_of_pages
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeNewAdmin(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
        $request->validate($rules);

        $this->usersRepository->create(
            $request->name,
            $request->email,
            $request->password,
            UsersGroupsEnum::Admin->value
        );

        return response()->json([
            'message' => 'Usuário criado com sucesso!'
        ], 201);
    }

    public function storeUserWithKey(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'user_group_name' => 'required|string'
        ];
        $request->validate($rules);

        // TODO: validate if user group have permission to create new user to this group in request

        $created_key = $this->usersRepository->createEmptyUserWithKey(
            $request->email,
            $request->user_group_name
        );

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'key' => $created_key
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user_id = $request->user()->id;
        $user_group_id = $request->user()->user_group_id_FK;

        $user_group = $this->userGroupRepository->getById($user_group_id);

        $is_same_user = $user_id === $id;
        $is_admin = $user_group->name === UsersGroupsEnum::Admin->value;

        if (!$is_same_user && !$is_admin) {
            return response()->json([
                'message' => 'Você não tem permissão para atualizar este usuário!'
            ], 403);
        };

        $rules = [
            'name' => 'string',
            'email' => 'email|unique:users,email,',
            'password' => 'min:6',
        ];

        $request->validate($rules);

        $userUpdateDTO = UserUpdateDTO::fromRequest($request);
        try {
            $this->usersRepository->update($id, $userUpdateDTO);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário!'
            ], 500);
        }

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!'
        ], 200);
    }

    public function updateWithKey(Request $request, string $key)
    {
        $user = $this->usersRepository->getByKey($key);
        $id = $user['id'];

        $rules = [
            'name' => 'required|string',
            'password' => 'required|min:6',
        ];

        $request->validate($rules);

        try {
            $userUpdateDTO = UserUpdateDTO::fromRequest($request);
            $this->usersRepository->update($id, $userUpdateDTO, true);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário!'
            ], 500);
        }

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
