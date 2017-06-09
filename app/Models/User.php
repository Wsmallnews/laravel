<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'avatar', 'github_name', 
        'source_driver', 'personal_website', 'wechat_qrcode', 'qq_qrcode', 'linked_in', 'company', 'pay_me',
        'github_id', 'qq_id', 'twitter_id', 'weibo_id', 'third_oper', 'identity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    /* =======================访问器=======================*/    
    
    
    
    /* =======================访问器 end=======================*/
    
    
    /* =======================验证器=======================*/    
    
    /**
     * 验证是否是管理员
     * @author @smallnews 2017-06-08
     * @return boolean [description]
     */
    public function isSuperAdmin(){
        if ($this->identity == 'admin') {
            return true;
        }
    }
    
    
    /* =======================验证器 end=======================*/
    
    
    /* =======================模型关联=======================*/
    public function topic(){
        return $this->hasMany('App\Models\Topic', 'user_id');
    }
    
    
    public function classify(){
        return $this->hasMany('App\Models\Classify', 'user_id');
    }
    
    /* =======================模型关联 end=======================*/
}
