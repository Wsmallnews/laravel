<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterUser extends Model
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('twitter_id', 'nick_name', 'name', 'email', 'avatar', 'user_id');
    
    
    public function getTwitterUserByThirdId($twitter_id = 0){
        return $this->where('twitter_id', $twitter_id)->first();
    }
}
