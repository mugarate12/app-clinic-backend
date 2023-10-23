<?php

namespace App\Interfaces\Repository;

use App\DTO\UsersGroupDTO;

interface IUserGroupRepository
{
    public function getById(string $id): UsersGroupDTO | null;
    public function getByName(string $name): UsersGroupDTO | null;
    public function index(): array;
};
