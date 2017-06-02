<?php namespace App\Repositories;

use Socialite;

class MySocialite{
    /*
        获取的所有第三方数据
     */
    public $socialiteUser = [];     
    
    
    /*
        获取的第三方处理过的简约数据
     */
    public $simSocialiteUser = [];
    
    /*
        allows the driver`s
     */
    protected $filterLogin = ['github', 'wechat', 'qq', 'weibo', 'twitter'];
    
    
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($driver)
    {
        $driver = in_array($driver, $this->filterLogin) ? $driver : 'qq';
        
        return Socialite::driver($driver)->redirect();
    }

    
	public function handleProviderCallback($driver = 'qq'){
		$driver = in_array($driver, $this->filterLogin) ? $driver : 'qq';
print_r($driver);
        $this->socialiteUser = Socialite::driver($driver)->user();
		
		return $this;
	}
	
    
    /**
     * 通过 token 获取 Socialite 用户
     * @author @smallnews 2016-12-28
     * @param  [type] $token [description]
     * @return [type]        [description]
     */
    public function getSocialiteUserFromToken($driver, $token){
        $this->socialiteUser = Socialite::driver($driver)->userFromToken($token);
        
        return $this->socialiteUser;
    }
    
    
    /**
     * getSocialiteUser
     * @author @smallnews 2016-12-28
     * @param  [type] $driver [description]
     * @return [type]         [description]
     */
    public function getsimSocialiteUser(){
        $this->simSocialiteUser = array(
           'token' => $this->socialiteUser->token,
           'id' => $this->socialiteUser->getId(),
           'avatar' => $this->socialiteUser->getAvatar(),
           'name' => $this->socialiteUser->getNickname(),
           'email' => $this->socialiteUser->getEmail()
        );
       
        return $this->simSocialiteUser;
    }
}
