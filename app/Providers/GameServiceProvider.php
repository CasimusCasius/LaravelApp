<?php

namespace App\Providers;

use App\Models\Game;
use App\Repository\Eloquent\GameRepository as EloquentGameRepository;
use App\Repository\GameRepository;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(GameRepository::class, EloquentGameRepository::class);
        $this->app->singleton(
            GameRepository::class,
            function ($app)
            {
                return new EloquentGameRepository($app->make(Game::class));
            }
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
