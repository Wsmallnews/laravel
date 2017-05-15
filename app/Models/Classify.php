<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classify extends CommonModel
{
    use SoftDeletes;        // 软删除
    
    protected $table = 'classify';
    
    protected $Guarded  = ['*'];	//不允许批量赋值

	protected $fillable = array('user_id', 'name', 'icon', 'sort');
}
