<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repository\IUserGroupRepository;
use App\Interfaces\Repository\IUsersRepository;
use App\Repositories\UsersGroupsRepository;
use App\Repositories\UsersRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IUserGroupRepository::class,
            UsersGroupsRepository::class
        );

        $this->app->bind(
            IUsersRepository::class,
            UsersRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
