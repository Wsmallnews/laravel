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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('desktop.index');
    }
}
