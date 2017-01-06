<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
       'user_id', 'classify_id', 'title', 'abstract', 'body', 
       'is_top', 'is_elite', 'view_num', 'review_num', 'support_num', 'is_publish', 'last_active_time'
    ];
    
    /* =======================查询scopes=======================*/
    
    /**
     * 查询发布的主题
     */
    public function scopePublished($query){
        return $this->where('is_publish', 1);
    }
    /* =======================查询scopes end=======================*/
    
    
    /* =======================访问器=======================*/    
    public function getNumAttribute()
    {
        return $this->review_num + $this->support_num;
    }
    
    
    /* =======================访问器 end=======================*/
    
    
    
    /* =======================模型关联=======================*/
    /**
     * 关联用户
     * @author @smallnews 2017-01-05
     * @return [type] [description]
     */
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    /**
     * 关联分类
     * @author @smallnews 2017-01-05
     * @return [type] [description]
     */
    public function classify(){
        return $this->belongsTo('App\Models\TopicClassify', 'classify_id');
    }
    /* =======================模型关联 end=======================*/
    
    
    public function setAbstract($abstract){
        $text = trim(preg_replace('/\s\s+/', ' ', strip_tags($abstract)));      // 过滤html，将多个空格转换成1个，去除两端空格
        
        return str_limit($text, 200);
    }
}
