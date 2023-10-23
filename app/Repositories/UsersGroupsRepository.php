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
        $model = UsersGroup::find($id);

        return UsersGroupDTO::fromModel($model);
    }

    public function getByName(string $name): UsersGroupDTO
    {
        $model = UsersGroup::where('name', $name)->first();

        return UsersGroupDTO::fromModel($model);
    }

    public function index(): array
    {
        $models = UsersGroup::all();

        return UsersGroupDTO::fromModels($models->toArray());
    }
};
