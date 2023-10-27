<?php

namespace App\DTO;

use App\Models\UsersGroup;

class UsersGroupDTO
{
    public string $id;
    public string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param UsersGroup $model
     * @return UsersGroupDTO
     */
    public static function fromModel(UsersGroup $model): UsersGroupDTO
    {
        return new UsersGroupDTO(
            $model->id,
            $model->name
        );
    }

    /**
    * @param UsersGroup[] $models
    * @return UsersGroupDTO[]
    */
    public static function fromModels(array $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = self::fromModel($model);
        }

        return $dtos;
    }
}
