<?php

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

Route::get('/', function ()
{
    return view('welcome');
});

Route::get('/hello/{name}', 'HelloController@hello');

$uri = '/example';
Route::get($uri, fn () => 'Jestem arrow GET');
Route::post($uri, fn () => 'Jestem POST');
Route::put($uri, fn () => 'Jestem PUT');
Route::patch($uri, fn () => 'Jestem PATCH');
Route::delete($uri, fn () => 'Jestem DELETE');
Route::options($uri, fn () => 'Jestem OPTIONS');

Route::match(['get', 'post'], '/match', function ()
{
    return 'Jestem GET i POST';
});

Route::any('/any', fn () => 'Wszystkie metody');

Route::view('/view/route', 'route.view');
