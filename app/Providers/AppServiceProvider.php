<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TopicClassify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 注册 前端导航 栏 单例
        $this->app->singleton('nav',function($app){
			$nav = session('nav', null);
            
            if(!$nav){
                $nav = TopicClassify::orderBy('sort', 'desc')->get();
                
                if(!$nav->isEmpty()){
                    session(['nav' => $nav]);
                }
            }

            return $nav;
		});
    }
}
