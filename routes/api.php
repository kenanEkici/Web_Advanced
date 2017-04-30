<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

//if you have a session, you have a role

//only specific roles can access specific api controllers

*/
Route::group(['middleware' => 'role'], function () {

    //GET routes --> controllers for JSON user output
    Route::get('/users', 'UserController@showAll');
    Route::get('/users/{id}', 'UserController@showById')->where('id', '[0-9]+');
    Route::get('/users/{name}', 'UserController@showByUsername')->where('name', '[A-Za-z]\w+');
    Route::get('/users/query/{query}', 'UserController@searchByIndex');
    //POST/UPDATE/DELETE routes --> controllers for JSON user controls
    Route::put('/users', 'UserController@update');
    Route::delete('/users', 'UserController@destroy');

    //GET routes --> controllers for JSON event output
    Route::get('/events', 'EventController@showAll');
    Route::get('/events/{id}', 'EventController@showById')->where('id', '[0-9]+');
    Route::get('/events/{name}', 'EventController@showByTitle')->where('name', '[A-Za-z]\w+');
    Route::get('/events/user/{username}','EventController@showByUser');

    //POST/UPDATE/DELETE routes --> controllers for JSON event output
    Route::put('/events', 'EventController@update');
    Route::post('/events', 'EventController@store');
    Route::delete('/events', 'EventController@destroy');

    Route::get('/sessionData', 'UserController@getDecryptedCookie');
});

Route::post('/register/user', 'UserController@store');
Route::post('/login', 'UserController@login');
Route::post('/logout', 'UserController@logout');
