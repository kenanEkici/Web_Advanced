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


Route::group(['middleware' => 'session'], function () {

    //only for users that have a session_id thus are logged in

    Route::get('/home', function()
    {
        return view('Homepage');
    });

    Route::get('/home/events', function()
    {
        return view('MyEvents');
    });

    Route::get('/home/profile', function()
    {
        return view('MyProfile');
    });
});


//no sessions or credentials needed
//for guests


Route::get('/login', function()
{
    return view('Login',['message'=>""]);
});


Route::get('/', function()
{
    return view('IndexHomepage');
});








