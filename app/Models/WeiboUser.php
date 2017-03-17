<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeiboUser extends Model
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('weibo_id', 'nick_name', 'name', 'email', 'avatar', 'user_id');
    
    
    public function getWeiboUser($user_id = 0){
        return $this->where('weibo_id', $user_id)->first();
    }
}
