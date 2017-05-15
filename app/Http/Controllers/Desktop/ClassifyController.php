<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
// use App\Http\Requests;
// use App\Models\Topic;
use App\Models\Classify;
// use App\Models\User;
use Validator;
use Auth;
// use DB;
// use MyUpload;

class ClassifyController extends CommonController
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
    
    
    // 个人分类列表
    public function index(){
        $user = Auth::user();
        $classify = $user->classify()->orderBy('sort')->get();
        
        return view('desktop.classify.index', [
            'classify' => $classify,
            'user' => $user
        ]);
    }
    
    
    /**
     * 分类 详情
     */
    public function show($id)
    {
        $user = Auth::user();
        $classify = $user->classify()->findOrFail($id);
    
        return view('desktop.users.show', [
            'title' => '分类详情',
            'classify' => $classify,
            'user' => $user
        ]);
    }
    
    
    public function create(){
        return view('desktop.classify.create', [
            'title' => '添加分类',
            'user' => Auth::user()
        ]);
    }
    
    
    /**
     * 保存 自定义分类
     * @author @smallnews 2017-01-04
     * @return [type] [description]
     */
    public function store(Request $request, Classify $classify){
        $this->validator($request->all())->validate();      // 验证失败，自动返回
        
        $classify->user_id = $this->guard()->id();
        $classify->name = $request->input('name');
        $classify->icon = $request->input('icon');
        $classify->sort = $request->input('sort');
        $classify->save();
        
        flash('添加成功', 'success');
        return redirect(route('classify.index'));
    }
    
    
    /**
     * 修改个人分类
     * @author @smallnews 2017-03-22
     */
    public function edit($id)
    {
        $user = Auth::user();
        $classify = $user->classify()->findOrFail($id);
        
        return view('desktop.classify.edit', [
            'title' => '修改分类',
            'classify' => $classify,
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
        $classify = Auth::user()->classify()->findOrFail($id);
        
        $this->validator($request->all())->validate();      // 验证失败，自动返回
        
        $classify->name = $request->input('name');
        $classify->icon = $request->input('icon');
        $classify->sort = $request->input('sort');
        
        $classify->save();

        flash('保存成功', 'success');
        return redirect()->route('classify.edit', ['id' => $classify->id]);
    }
    
    
    public function destroy($id){
        $topics = Auth::user()->classify()->findOrFail($id);
        $topics->delete();
        
        flash('删除成功', 'success');
        return redirect(route('user.show', Auth::id()));
    }
    
    /**
     * 验证信息完整性
     * @author @smallnews 2017-01-04
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected function validator($data){
        return Validator::make($data,[
            'name' => 'required'
        ]);
    }
}
