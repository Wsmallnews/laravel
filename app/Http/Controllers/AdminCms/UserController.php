<?php
namespace App\Http\Controllers\AdminCms;

use Request;
use Validator;
use Redirect;
use AuthUser;
use Session;
use Response;
use App\Models\User;
use App\Models\News;
use DB;
use \Exception;
use Event;

class UserController extends CommonController {

	/**
	 * initialize controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{
		//$this->middleware('home');
	}

	public function index(){
		// $pageRow = Request::input('rows',15);
		// $sort = Request::input('sort','id');
		// $order = Request::input('order','desc');
		// $keyword = Request::input('keyword','');
		// 
		// $user = AuthUser::user();
		// 
		// $userModel = User::where();
		// 
		// if(!empty($keyword)){
		// 	$userModel = $userModel->where('name','like',"%".$keyword."%");
		// }
		// 
        // $user_list = $userModel->orderBy($sort,$order)->paginate($pageRow);
		// 
	    // if(Request::ajax()){
	    //     return Response::json(array('error' => 0,'data' => array('list' => $user_list)));
	    // }else{
			return view('admincms.user.index');
	    // }
		
	}
}
