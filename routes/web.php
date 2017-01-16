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
Route::get('/old', 'HomeController@old');

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

Route::group(['prefix' => '', 'namespace' => 'Desktop'], function($router)
{
    $router->get('/', 'IndexController@index');
    
    // Auth::routes();      with Illuminate/Routing/Router.php  -> function auth
    $router->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $router->post('login', 'Auth\LoginController@login');
    $router->get('register', 'Auth\RegisterController@showRegistrationForm');
    $router->post('register', 'Auth\RegisterController@register');
    $router->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $router->post('password/reset', 'Auth\ResetPasswordController@reset');
    $router->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $router->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $router->post('logout', 'Auth\LoginController@logout');
    // Auth::routes(); end
    
    // fast login start
    $router->get('createUser', 'Auth\LoginController@showFastCreateUserForm')->name('createUser');
    $router->post('createUser', 'Auth\LoginController@createUser');
    $router->get('auth/driver', 'Auth\LoginController@redirectToProvider')->name('auth.driver');
    $router->get('auth/callback', 'Auth\LoginController@handleProviderCallback');
    // fast login end
    
    $router->get('topic', 'TopicsController@index');
    $router->get('topic/order/{class?}', 'TopicsController@index');
    $router->get('topic/by/{id?}', 'TopicsController@index');
    $router->get('topic/sort/{orderby?}', 'TopicsController@index')->where('orderby', '[a-z]+')->name('topic.sort');
    $router->get('topic/filter', 'TopicsController@index')->name('topic.filter');
    $router->get('topic/create', 'TopicsController@create')->name('topic.create');
    $router->get('topic/{id}/write', 'TopicsController@write')->where('id', '[0-9]+')->name('topic.write');
    $router->patch('topic/write', 'TopicsController@save')->name('topic.save');
    $router->get('topic/{id}', 'TopicsController@show')->where('id', '[0-9]+')->name('topic.show');
    // $router->get('topic/{id}/edit', 'TopicsController@edit')->name('topic.edit');
    // $router->patch('topic/{id}/edit', 'TopicsController@update')->name('topic.update');
    
    // Route::get('/', 'IndexController@index');
    $router->get('user/{id}', 'UsersController@index')->name('user.show');
    $router->get('user/personal', 'UsersController@personal')->name('user.personal');
    
    $router->resource('user', 'UserController');      // 用户操作
});


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

// 
// Event::listen('illuminate.query', function($sql, $param)
// {
//     Log::info($sql . ", with[" . join(',', $param) ."]");
//     var_dump($sql);//sql 预处理 语句
//     var_dump($param);
// });
