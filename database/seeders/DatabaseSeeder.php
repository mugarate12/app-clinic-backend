<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\UsersGroupsFactory;
use App\Enums\UsersGroupsEnum;
use App\Models\UsersGroup;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $uses_groups = UsersGroupsEnum::getValues();

        foreach ($uses_groups as $value) {
            $user_group_in_database = UsersGroup::where('name', $value)->first();

            if (is_null($user_group_in_database)) {
                UsersGroupsFactory::new()->create([
                    'name' => $value,
                ]);
            };
        };

        // create first admin user
        $administrator_user_group_in_database = UsersGroup::where('name', UsersGroupsEnum::Admin)->first();

        // get all users
        $users = User::all();

        if ($users->count() == 0) {
            User::factory()->create([
                'name' => 'admin',
                'email' => 'mail@mail.com',
                'password' => bcrypt('admin'),
                'user_group_id_FK' => $administrator_user_group_in_database->id,
            ]);
        }

    }
}
