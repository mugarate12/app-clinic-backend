<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\Repository\IUsersRepository;
use App\Models\User;

class UsersRepository extends IUsersRepository
{
    public function create(string $name, string $email, string $password, string $user_group): bool
    {
        $user_group = $this->userGroupRepository->getByName($user_group);

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'user_group_id_FK' => $user_group->id,
        ]);

        return true;
    }

    public function createEmptyUserWithKey(string $user_group): string
    {
        return '123456789';
    }

    public function getAll(string $user_group): array
    {
        return [];
    }

    public function getById(int $id): array
    {
        $user =  User::find($id);

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        return $user->toArray();
    }

    public function getByEmail(string $email): array
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        return $user->toArray();
    }

    public function checkUserPasswordByEmail(string $email, string $password): bool {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        return Hash::check($password, $user['password']);
    }

    public function createTokenByUserEmail(string $email, string $device_name): string {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        $token = $user->createToken($device_name)->plainTextToken;
        return $token;
    }

};
