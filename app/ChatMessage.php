<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends CommonModel
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('message', 'user_id');
}
