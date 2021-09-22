<?php

declare(strict_types=1);

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

Route::get('/', 'Home\MainPage')
    ->name('home.mainPage');

Route::get('users', 'UserController@list')
    ->name('get.users');

Route::get('users/{userId}', 'UserController@show')
    ->name('get.user.show');

//Route::get('users/{id}/profile', 'User\ProfilController@show')
//    ->name('get.user.profile');

Route::get('users/{id}/address', 'User\ShowAddress')
    ->where(['id' => '[0-9]+'])
    ->name('get.users.address');

//Route::resource('games', 'GameController');
Route::resource('games', 'GameController')
    ->only([
        'index', 'show'
    ]);

Route::resource('admin/games', 'GameController')
    ->only([
        'store', 'create', 'destroy'
    ]);
