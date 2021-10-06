<?php

declare(strict_types=1);

use App\Http\Middleware\RequestPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function ()
{

    Route::get('/', 'Home\MainPage')
        ->name('home.mainPage');

    // USER - ME
    Route::group(['prefix' => 'me', 'as' => 'me.', 'namespace' => 'User'], function ()
    {
        Route::get('profile', 'UserController@profile')->name('profile');
        Route::get('edit', 'UserController@edit')->name('edit');
        Route::post('update', 'UserController@update')->name('update');

        Route::get('games', 'GameController@list')->name('games.list');
        Route::post('games', 'GameController@add')->name('games.add');
        Route::delete('games', 'GameController@remove')->name('games.remove');
        Route::post('games/rate', 'GameController@rate')->name('games.rate');
    });


    // Users
    Route::get('users', 'User\UserController@list')
        ->name('get.users');

    // Route::get('users/{userId}', 'User\UserController@show')
    //     ->name('get.user.show');

    // //Route::get('users/{id}/profile', 'User\ProfilController@show')
    // //    ->name('get.user.profile');

    // Route::get('users/{id}/address', 'User\ShowAddress')
    //     ->where(['id' => '[0-9]+'])
    //     ->name('get.users.address');

    // Games

    Route::group(
        [
            'prefix' => 'b/games',
            'namespace' => 'Game',
            'as' => 'games.b.'
        ],
        function ()
        {
            Route::get('dashboard', 'BuilderController@dashboard')
                ->name('dashboard');

            Route::get('', 'BuilderController@index')
                ->name('list')
                ->middleware([RequestPage::class]);

            Route::get('{game}', 'BuilderController@show')
                ->name('show');
        }
    );
    Route::group(
        [
            'prefix' => 'e/games',
            'namespace' => 'Game',
            'as' => 'games.e.',
        ],
        function ()
        {
            Route::get('dashboard', 'EloquentController@dashboard')
                ->name('dashboard');

            Route::get('', 'EloquentController@index')
                ->name('list')
                ->middleware([RequestPage::class]);

            Route::get('{game}', 'EloquentController@show')
                ->name('show');
        }
    );

    Route::group(
        [
            'prefix' => 'games',
            'namespace' => 'Game',
            'as' => 'games.',
        ],
        function ()
        {
            Route::get('dashboard', 'GameController@dashboard')
                ->name('dashboard');

            Route::get('', 'GameController@index')
                ->name('list')
                ->middleware([RequestPage::class]);

            Route::get('{game}', 'GameController@show')
                ->name('show');
        }
    );
});
Auth::routes();
