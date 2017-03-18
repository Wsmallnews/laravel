<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Topic;
use App\Models\TopicClassify;
use Validator;
use App\Repositories\Markdown;
use App\Http\Traits\TopicOper;
use DB;

class TopicsController extends CommonController
{
    use TopicOper;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    
    /**
     * 主题列表页
     */
    public function index(Request $request, Topic $topic)
    {        
        $topic = $this->topicIndexFilter($topic);
        
        $topics = $topic->with('user', 'classify')->paginate(2);
        
        return view('desktop.topics.index', ['topics' => $topics]);
    }
    
    
    /**
     * 主题
     * @author @smallnews 2017-01-05
     * @param  Topic  $topic [description]
     * @param  [type] $id    [description]
     * @return [type]        [description]
     */
    public function show(Topic $topic, $id)
    {
        $topics = $topic->with('user', 'classify')->findOrFail($id);
        
        return view('desktop.topics.view', ['topic' => $topics]);
    }
}
