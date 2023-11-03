<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use App\Interfaces\Repository\IUsersRepository;
use App\DTO\Users\UserUpdateDTO;
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

    public function createEmptyUserWithKey(string $email, string $user_group): string
    {
        $user_group = $this->userGroupRepository->getByName($user_group);
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 9);

        User::create([
            'name' => '',
            'email' => $email,
            'password' => bcrypt(''),
            'key' => $random_string,
            'user_group_id_FK' => $user_group->id,
        ]);

        return $random_string;
    }

    public function getAll(string $user_group = null, int $offset = 0, int $limit = 10): array
    {
        $users = null;

        if ($user_group) {
            $user_group_doc = $this->userGroupRepository->getByName($user_group);

            if (!$user_group_doc) {
                throw new \Exception('Grupo de usuário não encontrado!');
            };

            $users = User::where('user_group_id_FK', $user_group_doc->id)
                ->offset($offset)
                ->limit($limit)
                ->get();
        } else {
            $users = User::offset($offset)
                ->limit($limit)
                ->get();
        };


        if (!$users) {
            return [];
        };

        return $users->toArray();
    }

    public function getAllCount(string $user_group = null): int {
        $total = null;

        if ($user_group) {
            $user_group_doc = $this->userGroupRepository->getByName($user_group);

            if (!$user_group_doc) {
                throw new \Exception('Grupo de usuário não encontrado!');
            };

            $total = User::where('user_group_id_FK', $user_group_doc->id)
                ->count();
        } else {
            $total = User::count();
        };

        return $total;
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

    public function getByKey(string $key): array
    {
        $user = User::where('key', $key)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        return $user->toArray();
    }

    public function checkUserPasswordByEmail(string $email, string $password): bool
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        return Hash::check($password, $user['password']);
    }

    public function createTokenByUserEmail(string $email, string $device_name): string
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        $user_group = $this->userGroupRepository->getById($user['user_group_id_FK']);
        if (!$user_group) {
            throw new \Exception('Grupo de usuário não encontrado!');
        };

        $token = $user->createToken($device_name, ["user_type:{$user_group->name}"])->plainTextToken;
        return $token;
    }

    public function update(string $id, UserUpdateDTO $userUpdateDTO, bool $turnKeyEmpty = false): bool
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception('Usuário não encontrado!');
        };

        if ($userUpdateDTO->name !== '') $user->name = $userUpdateDTO->name;
        if ($userUpdateDTO->email !== '') $user->email = $userUpdateDTO->email;
        if ($userUpdateDTO->password !== '') $user->password = bcrypt($userUpdateDTO->password);

        if ($turnKeyEmpty) $user->key = '';

        $user->save();

        return true;
    }
};
