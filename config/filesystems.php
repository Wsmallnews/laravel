<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. A "local" driver, as well as a variety of cloud
    | based drivers are available for your choosing. Just store away!
    |
    | Supported: "local", "ftp", "s3", "rackspace"
    |
    */

    'default' => 'local',

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => 's3',

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => 'your-key',
            'secret' => 'your-secret',
            'region' => 'your-region',
            'bucket' => 'your-bucket',
        ],

        'qcos' => [     // 腾讯云 对象存储
            'driver'    => 'qcos',
            'root' => env('QCLOUD_ROOT', 'http://img.smallnews.top/'),
            'bucket' => env('QCLOUD_BUCKET'),
            'api_cos_api_end_point' => env('QCLOUD_API_COS_API_END_POINT', "http://sh.file.myqcloud.com/files/v2/"),
            'app_id' => env('QCLOUD_APPID'),
            'secret_id' => env('QCLOUD_SECRET_ID'),
            'secret_key' => env('QCLOUD_SECRET_KEY'),
            'time_out' => env('QCLOUD_TIME_OUT', 180),
            'location' => env('QCLOUD_LOCATION', 'sh'),
            'version' => 'v4.2.3',
            'user_agent' => 'cos-php-sdk-v4.2.3',
        ], 
        
        'qiniu' => [
            'driver'  => 'qiniu',
            'domains' => [
                'default'   => 'onguivs9z.bkt.clouddn.com', //你的七牛域名
                // 'https'     => 'dn-laravelacademy.qbox.me',         //你的HTTPS域名
                // 'custom'    => 'static.laravelacademy.org',     //你的自定义域名
             ],
            'access_key'=> '5l7JkGxM_Oi1qDGkQ0EG5NkaOuLDccjE--gYUDNa',  //AccessKey
            'secret_key'=> 'b9GYMJDVBSOpfPCt1Tarn8u3RRXKu3rPX0A86aR3',  //SecretKey
            'bucket'    => 'smallnews',  //Bucket名字
            'notify_url'=> '',  //持久化处理回调地址
        ],
    ],

];
