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


// Route::get('/privacy', '');     // 隐私协议 twitter login
// Route::get('/terms', '');       // 服务条款 twitter login



Route::group(['prefix' => '', 'namespace' => 'Desktop'], function($router)
{
    $router->post('/myUpload', 'IndexController@upload')->name('myUpload');
    
    $router->get('/', 'IndexController@index');
    
    $router->get('fileTest/{filename?}', 'IndexController@fileTest')->name('fileTest')->where('filename', '^(.+)/(.+)/(.+)$');
    
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
    $router->get('auth/callback/{driver?}', 'Auth\LoginController@handleProviderCallback');
    $router->get('auth/driver/{type}', 'Auth\LoginController@redirectToProvider')->name('auth.bind');
    $router->get('auth/callback/{driver}/{type}', 'Auth\LoginController@handleProviderCallback');
    // fast login end
    
    
    // $router->get('topic/{id}/edit', 'TopicsController@edit')->name('topic.edit');
    // $router->patch('topic/{id}/edit', 'TopicsController@update')->name('topic.update');
    
    // Route::get('/', 'IndexController@index');
    
    // $router->get('user/personal', 'UsersController@personal')->name('user.personal');
    // $router->get('user/bind', 'UsersController@personal')->name('user.bind');
    // $router->get('user/{id}', 'UsersController@show');
    
    // 用户路由
    $router->resource('user', 'UsersController');
    
    // 话题路由
    $router->post('uploadTopicFiles', 'TopicsController@uploadTopicFiles');
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
    
    
    // $router->get('topic/create', 'TopicsController@create')->name('topic.create');
    // $router->get('topic/{id}/write', 'TopicsController@write')->where('id', '[0-9]+')->name('topic.write');
    // $router->patch('topic/write', 'TopicsController@save')->name('topic.save');
    
    
    // $router->get('topic/{id}', 'TopicsController@show')->where('id', '[0-9]+')->name('topic.show');
    
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
