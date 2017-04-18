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

Route::group(['middleware' => 'web'], function () {


    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/users', 'UserController@showAll');
    Route::get('/users/{id}', 'UserController@showById')->where('id', '[0-9]+');
    Route::get('/users/{name}', 'UserController@showByUsername')->where('name', '[A-Za-z]\w+');

    Route::put('/users', 'UserController@update');
    Route::post('/users', 'UserController@store');
    Route::delete('/users','UserController@destroy');

    Route::get('/events', 'EventController@showAll');
    Route::get('/events/{id}', 'EventController@showById')->where('id', '[0-9]+');
    Route::get('/events/{name}', 'EventController@showByTitle')->where('name', '[A-Za-z]\w+');

    Route::put('/events', 'EventController@update');
    Route::post('/events', 'EventController@store');
    Route::delete('/events','EventController@destroy');


    Route::get('/users/data/crud', function(){
        $repo = new Repositories\UserRepository();
        return view('UsersCrud', ['userList' => $repo->getAll()]);
    });

    Route::get('/events/data/crud', function () {
        $repo = new Repositories\EventRepository();
        return view('EventsCrud', ['eventList' => $repo->getAll()]);
    });

});



