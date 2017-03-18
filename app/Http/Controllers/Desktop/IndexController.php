<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;
use Cache;

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
