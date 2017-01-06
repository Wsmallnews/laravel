<?php 
namespace App\Http\Traits;

use Auth;
use Illuminate\Http\Request;
use Validator;

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
     * 创建新主题
     * @author @smallnews 2017-01-04
     * @return [type] [description]
     */
    public function create(Topic $topic){
        $topic->user_id = $this->guard()->id();
        $topic->save();
        
        flash('添加成功', 'success');
        return redirect(route('topic.write', $topic->id));
    }
    
    
    /**
     * [编辑主题]
     * @author @smallnews 2017-01-03
     * @param  Request       $request       [description]
     * @param  TopicClassify $topicClassify [description]
     * @return [type]                       [description]
     */
    public function write(Topic $topic, TopicClassify $topicClassify, $id = 0)
    {
        $topicClassifys = $topicClassify->orderBy('sort', 'desc')->get();
        
        $topic = $topic->where('id', $id)
            ->where('user_id', $this->guard()->id())->firstOrFail();

        return view('desktop.topics.createEdit', [
            'title' => '编辑主题',
            'topic' => $topic,
            'classify' => $topicClassifys
        ]);
    }
    
    /**
     * 保存
     * @author @smallnews 2017-01-03
     * @param  Request       $request       [description]
     * @param  Topic $topic [description]
     * @return [type]                       [description]
     */
    public function save(Request $request, Topic $topic)
    {
        $topics = $topic->where('id', $request->input('id'))
            ->where('user_id', $this->guard()->id())->firstOrFail();
        
        if($request->input('save_and_publish') !== null){
            $this->validator($request->all())->validate();
            
            $topics->is_publish = 1;
        }
        $topics = $this->setData($topics);
        
        $topics->save();
        
        if($request->ajax()){
            return response()->json(['error' => 0, 'info' => '保存成功']);
        }
        
        flash('保存成功', 'success');
        return redirect(url('topic/'.$topics->id));
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
        $markdown = new Markdown();
        
        $topic->user_id = 1;
        $topic->classify_id = request()->input('classify_id');
        $topic->title = trim(request()->input('title'));
        $topic->body_original = trim(request()->input('body'));
        $topic->body = $markdown->markdownToHtml(trim(request()->input('body')));
        $topic->abstract = $topic->setAbstract($topic->body);
        
        return $topic;
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
