<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QqUser extends Model
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('qq_id', 'nick_name', 'name', 'email', 'avatar', 'user_id');
    
    
    public function getQqUserByThirdId($qq_id = 0){
        return $this->where('qq_id', $qq_id)->first();
    }
}
