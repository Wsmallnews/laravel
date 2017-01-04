<?php
namespace App\Http\Controllers\Desktop;

use App\Http\Controllers\Controller;
use Auth;

class CommonController extends Controller {

	public function __construct()
	{
		$this->_initialize();
	}
	
	protected function guard()
    {
        return Auth::guard('web');
    }
}
