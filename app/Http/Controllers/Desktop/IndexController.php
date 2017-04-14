<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;
use Cache;
use Smallnews\Cos\QCloudCos;
use Storage;
use Illuminate\HTTP\File;
use Image;

class IndexController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // print_r(app('config')->get('qcloud'));
        // print_r($config);
        // exit;
        // $a = Image::make('storage/avatars/20170324/149033866201602757.png');
        // 
        // echo hash_file('sha1', $a->encode());
        // exit;
        // $b = $a->encode()->filesize();
        // print_r($b);
        // 
        // echo filesize($a->encode());
        // 
        // echo "-----------------------------------------------------------------------";
        // $c = file_get_contents('storage/avatars/20170324/149033866201602757.png');
        // 
        // $d = filesize($c);
        // print_r($d);
        // exit;
        // 
        // $a = QCloudCos::getAppId();
        // $b = app('qcloudcos')->listFolder('smallnews','/');
        // print_r($b);
        // print_r($a);exit;
        // 
        // // print_r(new File('images/elite.png'));exit;
        // // print_r(config('filesystems.disks.qcos'));exit;
        // // $disk = Storage::disk('public');
        // // $exists = $disk->getMetadata('avatars/20170324/149033866201602757.png');
        // 
        // $disk = Storage::disk('qcos');
        // $exists = $disk->put('1234567.png', 'storage/avatars/20170324/149033866201602757.png');
        // 
        // 
        // print_r($exists);exit;
        // $a = QCloudCos::createFolder('smallnews', 'test');
        // print_r($a);exit;
        // if(Cache::has('smallnews')){
        //     echo Cache::get('smallnews');
        // }else{
        //     Cache::put('smallnews','hello world', '6000');
        //     echo "The cache has been written to redis";
        // }
        // exit;
        // print_r(Auth::user());
        return view('desktop.index');
    }
    
}
