<?php

namespace App\Repositories;

use App\DTO\UsersGroupDTO;
use App\Interfaces\Repository\IUserGroupRepository;
use App\Models\UsersGroup;

class UsersGroupsRepository implements IUserGroupRepository
{
    public function __construct()
    {
    }

    public function getById(string $id): UsersGroupDTO
    {
        $user_group = UsersGroup::find($id);

        if (!$user_group) {
            throw new \Exception('Grupo de usuário não encontrado!');
        };

        return UsersGroupDTO::fromModel($user_group);
    }

    public function getByName(string $name): UsersGroupDTO
    {
        $user_group = UsersGroup::where('name', $name)->first();

        if (!$user_group) {
            throw new \Exception('Grupo de usuário não encontrado!');
        };

        return UsersGroupDTO::fromModel($user_group);
    }

    public function index(): array
    {
        $models = UsersGroup::all();

        return UsersGroupDTO::fromModels($models->toArray());
    }
};
