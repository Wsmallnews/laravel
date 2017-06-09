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
use App\Http\Traits\ThirdOper;

class UsersController extends CommonController
{
    use ThirdOper;
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
        
        $user->avatar = $request->input('avatar');
        $user->phone = $request->input('phone');
        $user->personal_website = $request->input('personal_website');
        $user->wechat_qrcode = $request->input('wechat_qrcode');
        $user->qq_qrcode = $request->input('qq_qrcode');
        $user->linked_in = $request->input('linked_in');
        $user->company = $request->input('company');
        $user->pay_me = $request->input('pay_me');
        
        $user->save();

        flash('保存成功', 'success');
        return redirect()->route('user.edit', ['id' => $user->id]);
    }
    
    
    /**
     * 第三方账号绑定
     * @author @smallnews 2017-06-03
     * @return [type] [description]
     */
    public function bind(){
        $user = Auth::user();
        
        return view('desktop.users.bind', [
            'title' => '账号绑定',
            'user' => $user
        ]);
    }
    
    
    /**
     * 管理中心
     * @author @smallnews 2017-06-03
     * @return [type] [description]
     */
    public function admin(){
        $user = Auth::user();
        
        if (!$user->isSuperAdmin()) {
            abort(404);
        }
        
        return view('desktop.users.admin', [
            'title' => '管理中心',
            'user' => $user
        ]);
    }
    
    
    /**
     * 上传网站资源文件
     * @author @smallnews 2017-06-09
     */
    public function uploadAsset() {
        $path = public_path('build/rev-manifest.json');

        if (file_exists($path)) {
            $manifest = json_decode(file_get_contents($path), true);
        }
        
        if (isset($manifest)) {
            $bucket = request()->input('type') == 'correct' ? 'smallnews' : 'smalltest';
            
            MyUpload::bucket($bucket);
            foreach ($manifest as $key => $value) {
                $file_path = public_path('build/'.$value);
                
                $result = MyUpload::uploadAsset($file_path, 'asset/'.pathinfo($file_path, PATHINFO_EXTENSION)."/");
                
                if ($result['error']){
                    break;
                }
            }
            
            return response()->json($result);
        }

        return response()->json(['error' => 1, 'info' => '上传失败']);
    }
    
    
    /**
     * 验证信息完整性
     * @author @smallnews 2017-01-04
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected function validator($data){
        return Validator::make($data, [
            'phone'=>'unique:users,id,'.Auth::id().'|regex:/^1[34578][0-9]{9}$/',
            'personal_website' => 'regex:/^(http:\/\/|https:\/\/).*$/',
        ]);
    }
}
