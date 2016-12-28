<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GithubUser extends CommonModel
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('github_id', 'nick_name', 'name', 'email', 'avatar', 'user_id');
    
    
    public function getGithubUser($user_id = 0){
        return $this->where('github_id', $user_id)->first();
    }
    
}
