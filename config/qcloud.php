<?php

return [

    /*
    |--------------------------------------------------------------------------
    | qcloud config file
    |--------------------------------------------------------------------------
    |
    | All of the qcloud Api config
    */

    'cos' => [
        'api_cos_api_end_point' => env('QCLOUD_API_COS_API_END_POINT', "http://sh.file.myqcloud.com/files/v2/"),
        'app_id' => env('QCLOUD_APPID'),
        'secret_id' => env('QCLOUD_SECRET_ID'),
        'secret_key' => env('QCLOUD_SECRET_KEY'),
        'time_out' => env('QCLOUD_TIME_OUT', 180),
        'location' => env('QCLOUD_LOCATION', 'sh'),
    ], 
];
