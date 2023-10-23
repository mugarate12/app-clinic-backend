<?php

namespace App\Enums;

enum UsersGroupsEnum: string
{
    case Admin = 'Administrador';
    case TechnicalManager = 'Responsavel tecnico';
    case Advisor = 'Representante comercial';

    public static function fromValue(string $name): string
    {
        foreach (self::cases() as $userGroup) {
            if ($name === $userGroup->name) {
                return $userGroup->value;
            }
        }

        throw new \ValueError("$name is not a valid");
    }

    public static function getValues(): array
    {
        return [
            self::Admin,
            self::TechnicalManager,
            self::Advisor,
        ];
    }
}
