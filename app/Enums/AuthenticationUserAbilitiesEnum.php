<?php

namespace App\Enums;


enum AuthenticationUserAbilitiesEnum: string
{

    case Admin = "user_type:Administrador";
    case TechnicalManager = "user_type:Responsavel tecnico";
    case Advisor = "user_type:Representante comercial";
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
