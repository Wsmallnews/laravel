<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;
use Cache;
// use Smallnews\Cos\QCloudCos;
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
        $img = Image::make("https://avatars.githubusercontent.com/u/22268221?v=3");
        
        echo md5_file("https://avatars.githubusercontent.com/u/22268221?v=3");
        echo "<br>";
        // echo md5_file($img->encode());
        exit;
        echo $img->mime();exit;
        return view('desktop.index');
    }
    
}
