<?php 
namespace App\Http\Traits;

use Auth;
use Illuminate\Http\Request;
use Validator;
use App\Models\Topic;
use App\Models\TopicClassify;
use App\Repositories\Markdown;
use MyUpload;
use Gate;

trait TopicOper
{    
    
    protected function topicIndexFilter($topic){
        $orderby = request()->orderby;
        $classify_id = request()->input('classify_id', 0);

        $topic = $topic->published();   // 必须已发布
        
        if($classify_id){
            $topic = $topic->where('classify_id', $classify_id);
        }
        
        return $topic;
    }

    
    
    /**
     * 保存新主题
     * @author @smallnews 2017-01-04
     * @return [type] [description]
     */
    public function store(Request $request, Topic $topic){
        $topic->user_id = $this->guard()->id();
        $topic->save();
        
        flash('添加成功', 'success');
        return redirect(route('topic.edit', $topic->id));
    }
    
    
    /**
     * [编辑主题]
     * @author @smallnews 2017-01-03
     * @param  Request       $request       [description]
     * @param  TopicClassify $topicClassify [description]
     * @return [type]                       [description]
     */
    public function edit($id)
    {
        $user = Auth::user();
        
        $classifys = $user->classify()->orderBy('sort', 'asc')->get();
        $topic = $user->topic()->findOrFail($id);
        
        return view('desktop.topics.edit', [
            'title' => '编辑主题',
            'topic' => $topic,
            'classify' => $classifys
        ]);
    }
    
    /**
     * 保存
     * @author @smallnews 2017-01-03
     * @param  Request       $request       [description]
     * @param  Topic $topic [description]
     * @return [type]                       [description]
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $topics = $user->topic()->findOrFail($id);
                
        if($request->input('save_and_publish') !== null && !$topics->is_public){
            $this->validator($request->all())->validate();
            
            $topics->is_publish = 1;
            $topics->published_at = date('Y-m-d H:i:s');
        }
        $topics = $this->setData($topics);
        
        $topics->save();
        
        if($request->ajax()){
            return response()->json(['error' => 0, 'info' => '保存成功']);
        }
        
        flash('保存成功', 'success');
        return redirect(route('topic.show', $id));
    }
    
    
    public function destroy($id){
        $topics = Auth::user()->topic()->findOrFail($id);
        $topics->delete();
        
        flash('删除成功', 'success');
        return redirect(route('user.show', Auth::id()));
    }
    
    
    /**
     * 当发布的时候，验证数据完整
     * @author @smallnews 2017-01-04
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    protected function validator($data){
        return Validator::make($data,[
            'classify_id' => 'required',
            'title' => 'required|max:255',
            'body' => 'required'
        ]);
    }
    
    
    /**
     * 设置数据
     * @author @smallnews 2017-01-06
     * @param  [type] $topic [description]
     */
    protected function setData($topic){
        $topic->classify_id = request()->input('classify_id');
        $topic->title = trim(request()->input('title'));
        $topic->body_original = trim(request()->input('body'));
        $topic->body = resolve('Markdown')->markdownToHtml(trim(request()->input('body')));
        $topic->abstract = $topic->setAbstract($topic->body);
        
        return $topic;
    }
    
    
    
    /**
     * 
     */
    public function uploadTopicFiles(Request $request){
        if ($request->hasFile('file')){
            $filename = MyUpload::upload($request->file('file'), 'topics');
        }
        
        return response()->json([
            'filename' => $filename
        ]);
    }
    
    // public function edit(Topic $topic, TopicClassify $topicClassify, $id)
    // {
    //     $topicClassifys = $topicClassify->orderBy('sort', 'desc')->get();
    //     $topics = $topic->findOrFail($id);
    //     
    //     return view('desktop.topics.createEdit', [
    //         'title' => '编辑主题',
    //         'topic' => $topics,
    //         'classify' => $topicClassifys
    //     ]);
    // }
    // 
    // public function update(Request $request, Topic $topic, $id)
    // {
    //     $this->validator($request->all())->validate();
    //     
    //     $topics = $topic->findOrFail($id);
    //     
    //     $topics = $this->setData($topics);
    //     
    //     $topics->save();
    //     
    //     flash('更新成功', 'success');
    //     return redirect(url('topic/'.$topics->id));
    // }
}
