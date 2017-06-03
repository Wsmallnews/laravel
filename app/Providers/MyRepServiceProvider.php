<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\MySocialite;
use App\Repositories\MyThirdLoginDriver;
use App\Repositories\MyHelper;

class MyRepServiceProvider extends ServiceProvider {

	/**
	 * 我的 类库 服务提供者
	 */

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(		// 绑定自己的第三方 Socialite
			'MySocialite',
			'MySocialite'
		);
		
		$this->app->bind(		// 第三方登录 处理 实例
			'MyThirdLoginDriver',
			'MyThirdLoginDriver'
		);
		
		$this->app->bind(		// 第三方登录 处理 实例
			'myHelper',
			'MyHelper'
		);
	}

}
