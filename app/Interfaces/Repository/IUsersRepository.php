<?php

namespace App\Interfaces\Repository;

use App\Interfaces\Repository\IUserGroupRepository;
use App\DTO\Users\UserUpdateDTO;

abstract class IUsersRepository
{
    protected $userGroupRepository;

    public function __construct(IUserGroupRepository $userGroupRepository)
    {
        $this->userGroupRepository = $userGroupRepository;
    }

    abstract public function create(string $name, string $email, string $password, string $user_group): bool;
    abstract public function createEmptyUserWithKey(string $email, string $user_group): string;

    abstract public function getAll(string $user_group = null, int $offset = 0, int $limit = 10): array;
    abstract public function getAllCount(string $user_group = null): int;
    abstract public function getById(int $id): array;
    abstract public function getByEmail(string $email): array;
    abstract public function getByKey(string $key): array;
    abstract public function checkUserPasswordByEmail(string $email, string $password): bool;
    /**
     * Make a token for a user by email to identify the user in the system and user group to identify the user group in the system
     */
    abstract public function createTokenByUserEmail(string $email, string $device_name): string;

    abstract public function update(string $id, UserUpdateDTO $userUpdateDTO, bool $turnKeyEmpty = false): bool;
};
