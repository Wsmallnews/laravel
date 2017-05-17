<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;
use Cache;
// use Smallnews\Cos\QCloudCosOper;
use Storage;
use Illuminate\HTTP\File;
use Image;
use MyUpload;

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
        $result = MyUpload::uploadCopy("http://tvax2.sinaimg.cn/crop.0.0.120.120.180/e544b016ly8fdteyqp8xtj203c03cq51.jpg", 'avatars');
        print_r($result);exit;
        
        return view('desktop.index');
    }
    
}
