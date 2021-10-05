<?php

namespace App\Providers;

use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\UserRepository as EloquentUserRepository;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(UserRepository::class, function ($app)
        {
            return new EloquentUserRepository($app->make(User::class));
        });
    }
}
