<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;

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
        // print_r(Auth::user());
        return view('desktop.index');
    }
    
}
