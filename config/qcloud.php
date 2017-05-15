<?php

return [

    'cos' => [     // 腾讯云 对象存储
        'driver'    => 'cos',
        'root' => env('QCLOUD_ROOT', 'http://smalltest-1252018639.picsh.myqcloud.com/'),
        'host' => env('QCLOUD_HOST', 'smalltest-1252018639.picsh.myqcloud.com'),
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
];
