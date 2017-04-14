<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;
use App\Models\TopicClassify;
use App\Models\User;
use Validator;
use Auth;
use DB;
use MyUpload;

class UsersController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }
    
    
    /**
     * 用户主页
     * @author @smallnews 2017-01-07
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @param  integer $id      [description]
     * @return [type]           [description]
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        $topic = $user->topic()->published()->with('classify')->paginate(20);

        return view('desktop.users.show', [
            'title' => '个人主页',
            'user' => $user,
            'topics' => $topic
        ]);
    }
    
    /**
     * 显示修改个人信息表单
     * @author @smallnews 2017-03-22
     * @param  integer $id      [用户id]
     * @return [type]           [description]
     */
    public function edit($id)
    {
        $user = Auth::user();
        if($user->id != $id){
            abort(404);
        }
        
        return view('desktop.users.edit', [
            'title' => '修改资料',
            'user' => $user
        ]);
    }
    
    
    /**
     * 修改个人信息
     * @author @smallnews 2017-03-22
     * @param  Request $request [description]
     * @param  User    $user    [description]
     * @param  integer $id      [description]
     * @return [type]           [description]
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if($user->id != $id){
            abort(404);
        }
        $this->validator($request->all())->validate();      // 验证失败，自动返回
        
        if ($request->hasFile('avatar')){
            $avatar_path = MyUpload::upload($request->file('avatar'), 'avatars');
            $user->avatar = $avatar_path;
        }
        
        if ($request->hasFile('wechat_qrcode')){
            $wechat_path = MyUpload::upload($request->file('wechat_qrcode'), 'general');
            $user->wechat_qrcode = $wechat_path;
        }
        
        if ($request->hasFile('qq_qrcode')){
            $qq_path = MyUpload::upload($request->file('qq_qrcode'), 'general');
            $user->qq_qrcode = $qq_path;
        }
        
        if ($request->hasFile('pay_me')){
            $pay_me = MyUpload::upload($request->file('pay_me'), 'general');
            $user->pay_me = $pay_me;
        }
        
        $user->phone = $request->input('phone');
        $user->personal_website = $request->input('personal_website');
        $user->linked_in = $request->input('linked_in');
        $user->company = $request->input('company');
        
        $user->save();

        flash('保存成功', 'success');
        return redirect()->route('user.edit', ['id' => $user->id]);
    }
    
    
    /**
     * 验证信息完整性
     * @author @smallnews 2017-01-04
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected function validator($data){
        return Validator::make($data,[
            'avatars'=>'image|between:0,5242880',
            'wechat_qrcode'=>'image|between:0,5242880',
            'qq_qrcode'=>'image|between:0,5242880',
            'pay_me'=>'image|between:0,5242880',
            'phone'=>'unique:users,id,'.Auth::id().'|regex:/^1[34578][0-9]{9}$/',
            'personal_website' => 'regex:/^(http:\/\/|https:\/\/).*$/',
        ]);
    }
}
