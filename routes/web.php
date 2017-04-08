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



Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function()
{
   return 'lol';
});

Route::resource('my', 'TestController');

