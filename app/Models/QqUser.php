<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqUser extends Model
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('qq_id', 'nick_name', 'name', 'email', 'avatar', 'user_id');
    
    
    public function getQqUser($user_id = 0){
        return $this->where('qq_id', $user_id)->first();
    }
}
