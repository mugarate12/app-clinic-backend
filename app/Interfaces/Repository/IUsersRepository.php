<?php

namespace App\Interfaces\Repository;

use App\Interfaces\Repository\IUserGroupRepository;

abstract class IUsersRepository
{
    protected $userGroupRepository;

    public function __construct(IUserGroupRepository $userGroupRepository)
    {
        $this->userGroupRepository = $userGroupRepository;
    }

    abstract public function create(string $name, string $email, string $password, string $user_group): bool;
    abstract public function createEmptyUserWithKey(string $user_group): string;

    abstract public function getAll(string $user_group): array;
    abstract public function getById(int $id): array;
    abstract public function getByEmail(string $email): array;
    abstract public function checkUserPasswordByEmail(string $email, string $password): bool;
    abstract public function createTokenByUserEmail(string $email, string $device_name): string;

};
