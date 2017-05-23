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



*/
//Grouping certain routes in a middleware so that only users with a session
//can access these routes

Route::group(['middleware' => 'session'], function () {

    //GET routes --> controllers for JSON user output
    Route::get('/users', 'UserController@showAll');
    Route::get('/users/{id}', 'UserController@showById')->where('id', '[0-9]+');
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

    //Get the decrypted cookie output to identify which user is using the session
    Route::get('/sessionData', 'UserController@getDecryptedCookie');
});

//Routes for authorizing guests
//geen session voor nodig dus ook niet gegroepeerd in middleware
Route::post('/register/user', 'UserController@store');
Route::post('/login', 'UserController@login');
Route::post('/logout', 'UserController@logout');

//Route for checking is a certain username exists
//Niet safe, zou anderser kunnen
Route::get('/users/{name}', 'UserController@showByUsername')->where('name', '[A-Za-z]\w+');
