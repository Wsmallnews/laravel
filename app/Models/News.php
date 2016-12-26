<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends CommonModel
{
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('title', 'desc', 'content', 'is_top');
}
