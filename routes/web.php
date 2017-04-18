<?php

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

//php artisan serve --port=80
// to run

use App\User;
use App\Event;
use App\Http\Repositories;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'web'], function () {


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/users', function () {
        $repo = new Repositories\UserRepository();
        return view('home', ['userList' => $repo->getAll()]);
    });

    Route::post('/users','UserController@store', function () {
        $repo = new Repositories\UserRepository();
        return view('home', ['userList' => $repo->getAll()]);
    });

    Route::get('/events', function () {
        $repo = new Repositories\EventRepository();
        return view('login', ['eventList' => $repo->getAll()]);
    });
});



