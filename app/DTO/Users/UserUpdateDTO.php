<?php

namespace App\DTO\Users;

use Illuminate\Http\Request;

class UserUpdateDTO
{
    public string $name = '';
    public string $email = '';
    public string $password = '';

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public static function fromRequest(Request $request): UserUpdateDTO
    {
        return new UserUpdateDTO(
            $request->name ?? '',
            $request->email ?? '',
            $request->password ?? ''
        );
    }
};
