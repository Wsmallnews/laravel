<?php namespace App\Repositories;

use App\Contracts\MyUpload;
use Session;
use Image;
use Storage;

class QCosUpload implements MyUpload {

	private $img = '';				//图片对象
	private $save_path = '';		//最终文件保存路径
	private $mime_type = '';		//文件mime 类型
	private $extension = '';		//图片后缀名
	private $tmp_path = '';			//临时文件路径
	private $dir = '/';		//上传文件保存根目录
	private $real_dir = '';			//图片真实保存目录
	private $filename = '';			//生成文件文件名，不带后缀
    private $filesize = '';			//文件大小

	public function __construct(){		
		
	}

	public function upload($file, $type = 'avatars'){
		//文件的扩展名
		$this->entension = $file->getClientOriginalExtension();	//获取文件的扩展名
		$this->tmp_path = $file->getRealPath();	//这个表示的是缓存在tmp文件夹下的文件的绝对路径
		$this->mime_type = $file->getMimeType();	//获取文件mime 类型
		$this->filename = $file->hashName();		// 根据hash 值 生成文件名
        $this->filesize = $file->getClientSize();
		
		// 设置上传目录
		$this->setRealDir($type);

		// 生成图片完整路径，包括文件名
		$this->setDefaultPath();
		
		// 获取裁剪尺寸
		$this->zoomType($type);

		if(!$this->driver()->exists($this->save_path)){
			$this->img = Image::make($this->tmp_path);

			//保存图片
			$this->saveImg($type);		// 裁剪图片，打水印，并保存图片
            
			return $this->normalizerPath(config('filesystems.disks.qcos.root')).$this->normalizerPath($this->save_path);	// 返回 url  图片访问 路径
		}else{
			return false;
		}
	}
	

	/**
	 * 保存图片
	 */
	private function saveImg($type){
		foreach($this->cut_img as $key => $value){
            $img = $this->img;
			//根据预定尺寸裁剪图片

			if($type == 'avatars'){
				//正方形
				$img->fit($value[0],$value[0]);
			}else{
				//同比缩放
				$img->widen($value[0], function ($constraint) {
				    $constraint->upsize();
				});
			}

			//水印，暂时不开启
			// $this->img->insert(public_path().'/images/watermark.png','bottom-right');

            $save_tmp_path = public_path().'/tmp_file/'.$this->filename;
            $img->save($save_tmp_path);     // 保存到临时文件夹
            
			//设置图片路径
			if($value[1]){
				$save_path = $this->save_path;
			}else{
				$save_path = $this->getRealPath($value[0]);
			}
            
            $this->driver()->put($save_path, $save_tmp_path);
            
            @unlink($save_tmp_path);
		}
	}

	//设置文件保存目录
	private function setRealDir($type){
		$date_dir = date('Ymd');

		$this->real_dir = $this->dir.'/'.$type.'/'.$date_dir.'/';

		$this->driver()->makeDirectory($this->real_dir);
	}

	/*
		设置默认文件保存路径，带文件名
	 */
	private function setDefaultPath(){
		$this->save_path = $this->real_dir.$this->filename;
	}


	/*
		获取处理过的文件保存路径，带文件名
	 */
	private function getRealPath($size){

		return $this->real_dir.$this->filename."_".$size.'.'.$this->entension;
	}

	/*
		图片缩放类型
	 */
	private function zoomType($zoom_type){
		switch($zoom_type){
			case 'avatars' :				// 用户头像
				$this->cut_img[0][] = 400;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 200;
				$this->cut_img[1][] = 1;
				break;
			case 'topics' :					// 主题图片		, 限制最大宽缩放
				$this->cut_img[0][] = 1440;
				$this->cut_img[0][] = 1;
				break;
			case 'general' :					// 普通图片		, 限制最大宽缩放
				$this->cut_img[0][] = 800;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 400;
				$this->cut_img[1][] = 1;
				break;
			default :						// 默认，普通图片		, 限制最大宽缩放
				$this->cut_img[0][] = 800;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 400;
				$this->cut_img[1][] = 1;
				break;
		}
	}
	
	
	// 优化 url 图片地址
	private function normalizerPath($path) {
		if(preg_match('/^(http:\/\/|https:\/\/).*$/', $path) == 0){	// 不是http:// 或者 https://
			if (preg_match('/^\//', $path) == 0) {		// 如果开头没有 / ,则增加一个 /
	            $path = '/' . $path;
	        }
			
			// Remove unnecessary slashes.
			$path = preg_replace('#/+#', '/', $path);	// 如果中间出现  // 或者 ///... 替换成 /
		}else {
			if (substr($path, strlen($path) - 1) == '/') {		// 如果结尾 有 / ,则截取掉 /
	            $path = substr($path, 0, strlen($path) - 1);
	        }
		}

        return $path;
    }
	
	
	// 获取驱动
	public function driver(){
		return Storage::disk('qcos');
	}
}
