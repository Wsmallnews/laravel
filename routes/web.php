<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    // abort(404,'the page you are looking for could not be found.');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
