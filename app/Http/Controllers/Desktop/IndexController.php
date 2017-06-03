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
use MyHelper;

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
    public function index(Request $request)
    {
        return view('desktop.index');
    }
    
}
