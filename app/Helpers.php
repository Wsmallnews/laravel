<?php

/**
 * 根据当前时间获取时间 文件名
 */
if ( ! function_exists('time_name')) {
    function time_name($bit = 3){
        $time = explode(' ',microtime());
        $accuracy = "%.".$bit."f";
        
        $float_time = sprintf($accuracy, $time[1].$time[0]);
        
        return str_replace('.','',$float_time).rand(0,99);
    }
}

    
