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


//only for users that have a session_id thus are logged in
Route::group(['middleware' => 'session'], function () {

    Route::get('/home', function()
    {
        return view('Homepage');
    });

    Route::get('/events', function()
    {
        return view('MyEvents');
    });

    Route::get('/agenda', function()
    {
        return view('Agenda');
    });

    Route::get('/profile', function()
    {
        return view('MyProfile');
    });
});

//no sessions or credentials needed
//for guests
Route::get('/', function()
{
    return view('Login',['message'=>""]);
});










