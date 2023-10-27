<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\Repository\IUsersRepository;
use App\Enums\UsersGroupsEnum;

class UserController extends Controller
{


    public function __construct(
        protected IUsersRepository $usersRepository,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
