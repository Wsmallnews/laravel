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

Route::get('/test',function(){
    // try {
    //     App\Models\User::findOrFail(5);
    //     echo "sss";
    // }catch(\Exception $e){
    //     echo 'abc';
    //     print($e->getMessage());
    // }
    
    // var_dump();
    // return;
    $chat = App\Models\ChatMessage::create([
        'message' => 'zheshixiaoxi1',
        'aaa' => 'zheshixiaoxi1',
        'user_id' => 123,
    ]);
    var_dump($chat);
    return ;
});

Route::group(['prefix' => '', 'namespace' => 'Desktop'], function()
{
    Route::get('/', 'IndexController@index');
    
    Auth::routes();
    
    Route::get('createUser', 'LoginController@showFastCreateUserForm');
    Route::post('createUser', 'LoginController@createUser')->name('createUser');
    Route::get('auth/driver', 'Auth\LoginController@redirectToProvider')->name('auth.driver');
    Route::get('auth/callback', 'Auth\LoginController@handleProviderCallback');
    
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
