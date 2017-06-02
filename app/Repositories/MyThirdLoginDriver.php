<?php namespace App\Repositories;

use App\Models\GithubUser;
use App\Models\QqUser;
use App\Models\WeiboUser;
use App\Models\TwitterUser;
use MySocialite;

class MyThirdLoginDriver{
	// protected $socialiteUser = null;

	/**
	 * 获取第三方用户,通过 第三方 id {driver_id} 获取第三方用户
	 * @author @smallnews 2017-05-24
	 */
	public function getThirdUserByThirdId($driver, $third_id) {
		echo $third_id."<br>";
		// $this->socialiteUser = $socialiteUser;
		$class = "App\\Models\\".ucfirst($driver)."User";
		
		// if (!class_exists($class)) {
		// 	abort('third login driver not found');
		// }
		$thirdUser = new $class();
		print_r($thirdUser);
		return $thirdUser->{'get'.ucfirst($driver).'UserByThirdId'}($third_id);
	}

	
	/**
	 * 获取第三方用户,通过 id {id} 获取第三方用户
	 * @author @smallnews 2017-05-24
	 */
	public function getThirdUserById($driver, $id) {
		// $this->socialiteUser = $socialiteUser;
		$class = ucfirst($driver)."User";
		
		if (!class_exists($method)) {
			abort('third login driver not found');
		}
		$thirdUser = new $class();
		return $thirdUser->find($id);
	}


    /**
     * Create 第三方用户 user
     *
     * @param  array  $data
     * @return User
     */
    protected function createThirdUser($driver, $socialiteUser, $user_id = '')
    {
        $method = "create".ucfirst($driver)."User";
		
		if (!method_exists($method)) {
			abort('third login driver not found');
		}
		
        return $this->$method($socialiteUser);
    }
    
    /**
     * [创建github 用户]
     * @author @smallnews 2017-01-20
     */
    protected function createGithubUser($githubUser, $user_id = ''){
        return GithubUser::create([
            'github_id' => $githubUser->getId(),
            'nick_name' => $githubUser->getNickname(),
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'avatar' => $githubUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    /**
     * [创建 qq 用户]
     * @author @smallnews 2017-01-20
     */
    protected function createQqUser($qqUser, $user_id = ''){
        return QqUser::create([
            'qq_id' => $qqUser->getId(),
            'nick_name' => $qqUser->getNickname(),
            'name' => $qqUser->getName(),
            'email' => $qqUser->getEmail(),
            'avatar' => $qqUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    
    /**
     * [创建 weibo 用户]
     * @author @smallnews 2017-03-17
     */
    protected function createWeiboUser($weiboUser, $user_id = ''){
        return WeiboUser::create([
            'weibo_id' => $weiboUser->getId(),
            'nick_name' => $weiboUser->getNickname(),
            'name' => $weiboUser->getName(),
            'email' => $weiboUser->getEmail(),
            'avatar' => $weiboUser->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
    /**
     * [创建 weibo 用户]
     * @author @smallnews 2017-03-17
     */
    protected function createTwitterUser($twitter, $user_id = ''){
        return TwitterUser::create([
            'twitter_id' => $twitter->getId(),
            'nick_name' => $twitter->getNickname(),
            'name' => $twitter->getName(),
            'email' => $twitter->getEmail(),
            'avatar' => $twitter->getAvatar(),
            'user_id' => $user_id
        ]);
    }
    
}
