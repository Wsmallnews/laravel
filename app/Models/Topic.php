<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
       'user_id', 'classify_id', 'title', 'abstract', 'body', 
       'is_top', 'is_elite', 'view_num', 'review_num', 'support_num', 'last_active_time'
    ];
    
    
    
    public function setAbstract($abstract){
        $text = trim(preg_replace('/\s\s+/', ' ', strip_tags($abstract)));      // 过滤html，将多个空格转换成1个，去除两端空格
        
        return str_limit($text, 200);
    }
}
