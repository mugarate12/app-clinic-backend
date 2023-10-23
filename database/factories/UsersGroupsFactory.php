<?php

namespace Database\Factories;

class UsersGroupsFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    protected $model = \App\Models\UsersGroup::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
