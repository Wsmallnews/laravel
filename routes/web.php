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

// Route::get('/home', function () {
//     // abort(404,'the page you are looking for could not be found.');
//     return view('welcome');
// });


Route::get('/home', 'HomeController@index');

Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['prefix' => '', 'namespace' => 'Desktop'], function()
{
    Auth::routes();
    
    Route::get('/', 'IndexController@index');
    // Route::get('/', 'IndexController@index');
    Route::resource('user', 'UserController');      // 用户操作
});

Auth::routes();

//管理控制台路由组
Route::group(['prefix' => 'admincms', 'namespace' => 'AdminCms'], function($router)
{
    $router->get('/', 'IndexController@index')->name('admin.index');
    $router->get('index', 'IndexController@index');
    
    $router->get('news', 'NewsController@index')->name('admin.news');
    $router->get('user', 'UserController@index')->name('admin.user');
    $router->get('list', 'NewsController@lists')->name('admin.list');
    $router->get('example', 'NewsController@index')->name('admin.example');
    $router->get('newslist', 'NewsController@lists');
    
    
    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', 'LoginController@login');
    $router->get('logout', 'LoginController@logout');

    
});

// Route::get('/admin', 'HomeController@index');
