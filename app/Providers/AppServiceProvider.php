<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\TopicClassify;
use Illuminate\Support\Facades\Cache;

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
            $nav = Cache::get('nav', function() {
                $nav = TopicClassify::orderBy('sort', 'desc')->get()->toArray();
                if(!empty($nav)){
                    Cache::put('nav', $nav, '6000');
                }
            });

            return $nav;
		});

    }
}
