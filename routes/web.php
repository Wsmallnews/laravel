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

Route::get('home', 'HomeController@index');
Route::get('old', 'HomeController@old');

// Route::get('/privacy', '');     // 隐私协议 twitter login
// Route::get('/terms', '');       // 服务条款 twitter login

// 文件上传
Route::post('myUpload', 'FileController@upload')->name('myUpload');

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
    
    // third login start
    $router->get('thirdLogin', 'Auth\LoginController@thirdLogin')->name('auth.thirdLogin');
    $router->get('auth/callback/{driver}', 'Auth\LoginController@handleProviderCallback');
    
    $router->get('createUser', 'Auth\LoginController@showFastCreateUserForm')->name('createUser');
    $router->post('createUser', 'Auth\LoginController@createUser');
    // fast login end
    
    // $router->get('auth/driver', 'Auth\LoginController@redirectToProvider')->name('auth.driver');
    
    
    
    
    
    
    
    
    
    // $router->get('topic/{id}/edit', 'TopicsController@edit')->name('topic.edit');
    // $router->patch('topic/{id}/edit', 'TopicsController@update')->name('topic.update');
    
    // Route::get('/', 'IndexController@index');
    
    // $router->get('user/personal', 'UsersController@personal')->name('user.personal');
    // $router->get('user/{id}', 'UsersController@show');
    
    // 用户路由
    $router->post('admin/uploadAsset', 'UsersController@uploadAsset')->name('admin.uploadAsset');   // 第三方账号绑定
    $router->get('user/bind', 'UsersController@bind')->name('user.bind');   // 第三方账号绑定
    $router->get('user/thirdBind', 'UsersController@thirdBind')->name('user.thirdBind');
    $router->get('user/thirdUnbind', 'UsersController@thirdUnbind')->name('user.thirdUnbind');
    $router->get('user/admin', 'UsersController@admin')->name('user.admin');   // 管理中心
    
    $router->resource('user', 'UsersController');
    
    // 话题路由
    $router->resource('topic', 'TopicsController', ['except' => [
        'create'
    ]]);

    // 个人分类路由
    $router->resource('classify', 'classifyController');
    
    
    
    // $router->get('topic', 'TopicsController@index');
    
    $router->get('topic/order/{class?}', 'TopicsController@index');
    $router->get('topic/by/{id?}', 'TopicsController@index');
    $router->get('topic/sort/{orderby?}', 'TopicsController@index')->where('orderby', '[a-z]+')->name('topic.sort');
    $router->get('topic/filter', 'TopicsController@index')->name('topic.filter');
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

// Event::listen('illuminate.query', function($sql, $param)
// {
//     Log::info($sql . ", with[" . join(',', $param) ."]");
//     var_dump($sql);//sql 预处理 语句
//     var_dump($param);
// });
