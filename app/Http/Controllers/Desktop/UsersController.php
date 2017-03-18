<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;
use App\Models\TopicClassify;
use App\Models\User;
use Validator;
use DB;

class UsersController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    
    
    /**
     * 用户主页
     * @author @smallnews 2017-01-07
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @param  integer $id      [description]
     * @return [type]           [description]
     */
    public function index(Request $request, User $user, $id = 0)
    {   
        $users = $user->findOrFail($id);
        
        $topics = $users->topic()->published()->with('classify')->paginate(20);

        return view('desktop.users.index', [
            'title' => '个人主页',
            'user' => $users,
            'topics' => $topics
        ]);
    }
    
    
    /**
     * [个人中心]
     * @author @smallnews 2017-01-07
     * @return [type] [description]
     */
    public function personal(Request $request){
        return view('desktop.users.personal');
    }
}
