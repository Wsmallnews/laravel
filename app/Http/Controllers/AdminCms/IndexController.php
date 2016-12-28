<?php
namespace App\Http\Controllers\AdminCms;

use Request;
use Validator;
use Redirect;
use Response;
use Auth;

class IndexController extends CommonController {

	/**
	 * initialize controller instance.
	 *
	 * @return void
	 */
	public function _initialize()
	{
		$this->middleware('auth.admin:admin');
	}

	public function index(){print_r(Auth::user());
		return view('admincms.index');
	}

	public function lists(){
		$data = Request::all();

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

		$news = new News();

		if(!empty($data['keyword'])){
			$news = $news->where('title', 'like', '%'.$data['keyword'].'%');
		}

        $article_list = $news->orderBy('id','desc')->paginate($pageRow);

		if(Request::ajax()){

	        $view = view('desktop.news.li',array('article_list' => $article_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));
	    }else{
	        return view('home.article.adminLists',array('article_list' => $article_list));
	    }
	}


	/**
	 * 管理员文章列表
	 *
	 * @return Response
	 */
	public function adminLists() {
		$data = Request::all();
		$sort = Request::input('sort','id');
		$order = Request::input('order','desc');

	    $pageRow = isset($data['rows']) ? $data['rows'] : 15;

		$article = new Article();
		$article = $article->withTrashed();
		if(!empty($data['keyword'])){
			$article = $article->where('title', 'like', '%'.$data['keyword'].'%');
		}

        $article_list = $article->orderBy($sort,$order)->paginate($pageRow);

	    if(Request::ajax()){

	        $view = view('home.article.adminLi',array('article_list' => $article_list));

	        return Response::json(array('error'=>0,'data'=>array('html'=>$view->render())));

	    }else{
	        return view('home.article.adminLists',array('article_list' => $article_list));
	    }
	}

    public function add() {

		$article = new Article();

        return view('home.article.add',array('article' => $article,'title' => '添加'));
    }

	public function edit($id = 0){
		$article = Article::find($id);

		return view('home.article.add',array('article' => $article,'title' => '修改'));
	}

    public function doAddEdit() {
        $data = Request::all();

		if(empty($data['description'])){
			$data['description'] = mb_substr($data['content'],0,200,'utf-8');
		}

		if(!isset($data['is_top'])){
			$data['is_top'] = 0;
		}

		$validate = Validator::make($data,Article::addEditRole(),Article::addEditRoleMsg());

        if($validate->fails()){
            return Redirect::back()->withInput($data)->withErrors($validate->errors());
        }

		DB::beginTransaction();
		try{

			$article = new Article();

			if($data['id']){
				$article = $article->find($data['id']);
			}

			$article->fill($data);

			$article->save();

			$log_data = array(
				'log_info' => '资讯：添加/编辑成功【id：'.$article->id."】",
			);
			Event::fire(new AdminLog($log_data));

			DB::commit();

	        return redirect()->intended('home/adminArticleList')->withSuccess('文章保存成功');

		}catch(Exception $e){
			print_r($e->getMessage());
			DB::rollback();
			// return Redirect::back()->withInput(Request::all())->withErrors('文章保存失败');
		}
    }


	public function articleTop(){
		$data = Request::all();

		$article = Article::findOrFail($data['id']);

		if($data['type'] == 'top'){
			$article->is_top = 1;
		}else{
			$article->is_top = 0;
		}

		$article->save();

		return Response::json(array('error' => 0,'info' => '操作成功'));
	}

	public function articleDel(){
		$data = Request::all();

		$article = Article::withTrashed()->find($data['id']);

		if($data['type'] == 'del'){
			if(!$article->trashed()){
				$article->delete();
			}
		}else{
			if($article->trashed()){
				$article->restore();
			}
		}

		return Response::json(array('error' => 0,'info' => '操作成功'));
	}

}
