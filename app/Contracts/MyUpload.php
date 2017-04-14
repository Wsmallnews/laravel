<?php namespace App\Contracts;

interface MyUpload extends Contract {
    
    /**
     * 文件上传接口
     * @author @smallnews 2017-03-29
     * @param  [type] $file [接收到的文件]
     * @param  [type] $type [文件类型，例如 avatar 头像]
     * @return [type]       [file url | false]
     */
    // public function upload($file, $type);
    
    
    /**
     * 使用的磁盘驱动
     * @author @smallnews 2017-03-29
     * @return [type] [磁盘实例]
     */
    // public function driver();
}
