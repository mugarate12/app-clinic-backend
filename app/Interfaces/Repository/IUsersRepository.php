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

    abstract protected function create(string $name, string $username, string $email, string $password, string $user_group): bool;
    abstract protected function createEmptyUserWithKey(string $user_group): string;
};
