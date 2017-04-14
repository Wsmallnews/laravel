<?php namespace App\Repositories\Uploads;

use App\Repositories\Upload;
use Session;
use Image;
use Hp;
use Storage;

class LoaclUpload extends Upload {

	private $img = '';				//图片对象
	private $real_path = '';		//最终文件保存路径
	private $real_default_path;		//缩略图真是路径
	private $mime_type = '';		//文件mime 类型
	private $extension = '';		//图片后缀名
	private $tmp_path = '';			//临时文件路径
	private $dir = 'uploads';		//上传文件保存根目录
	private $real_dir = '';			//图片真实保存目录
	private $prefix = '';			//生成文件文件名，不带后缀

	private $cut_img = [['800',0],['400',1],['200',0]];			//图片尺寸
	private $z_type = 'W';
	private $default_style = 'jpg';	//默认格式



	public function __construct(){
		$this->prefix = Hp::mitime(4).rand(0,99);
	}

	public function upload($file,$type = 'logo',$zoom_type = 'default'){
		$img_info = getimagesize($file);	//获取文件信息
		//文件的扩展名
		$this->entension = $file->getClientOriginalExtension();	//获取文件的扩展名
		$this->tmp_path = $file->getRealPath();	//这个表示的是缓存在tmp文件夹下的文件的绝对路径
		$this->mime_type = $file->getMimeType();	//获取文件mime 类型
		$this->original_width = $img_info[0];	//获取文件mime 类型
		$this->original_height = $img_info[1];	//获取文件mime 类型

		$this->setRealDir($type);

		$this->setDefaultPath();

		$this->zoomType($zoom_type);

		if(!Storage::exists($this->real_path)){
			$this->img = Image::make($this->tmp_path);

			//保存图片
			$this->saveImg();

			return $this->real_default_path;
		}else{
			return false;
		}
	}


	/**
	 * 保存图片
	 */
	private function saveImg(){
		foreach($this->cut_img as $key => $value){
			//根据预定尺寸裁剪图片

			if($this->z_type == 'W'){
				//正方形
				$this->img->fit($value[0],$value[0]);
			}else{
				//同比缩放
				$this->img->widen($value[0]);
			}

			//水印，暂时不开启
			if(false){
				$this->img->insert(public_path().'/images/watermark.png','bottom-right');
			}

			//设置图片路径
			if($value[1]){
				$save_path = $this->real_default_path;
				Storage::put($save_path, $this->img->encode());
			}else{
				$save_path = $this->getRealPath($value[0]);
				Storage::put($save_path, $this->img->encode($this->default_style));
			}
		}
	}

	//设置文件保存目录
	private function setRealDir($type){
		$date_dir = date('Ymd');

		$this->real_dir = $this->dir.'/'.$type.'/'.$date_dir.'/';

		Storage::makeDirectory($this->real_dir);
	}

	/*
		设置默认文件保存路径，带文件名
	 */
	private function setDefaultPath(){

		$this->real_default_path = $this->real_dir.$this->prefix.'.'.$this->entension;
	}

	/*
		获取处理过的文件保存路径，带文件名
	 */
	private function getRealPath($size){

		return $this->real_dir.$this->prefix.'.'.$this->entension."_".$size.'.'.$this->default_style;
	}

	/*
		图片缩放类型
	 */
	private function zoomType($zoom_type){
		switch($zoom_type){
			case 'IMG800X400X200W' :
				$this->cut_img[0][] = 800;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 400;
				$this->cut_img[1][] = 1;
				$this->cut_img[2][] = 200;
				$this->cut_img[2][] = 0;
				$this->z_type = 'W';
				break;
			case 'IMG320X160X80W' :
				$this->cut_img[0][] = 320;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 160;
				$this->cut_img[1][] = 1;
				$this->cut_img[2][] = 80;
				$this->cut_img[2][] = 0;
				$this->z_type = 'W';
				break;
			case 'IMG800X400X200S' :
				$this->cut_img[0][] = 800;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 400;
				$this->cut_img[1][] = 1;
				$this->cut_img[2][] = 200;
				$this->cut_img[2][] = 0;
				$this->z_type = 'S';
				break;
			case 'IMG320X160X80S' :
				$this->cut_img[0][] = 320;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 160;
				$this->cut_img[1][] = 1;
				$this->cut_img[2][] = 80;
				$this->cut_img[2][] = 0;
				$this->z_type = 'S';
				break;
			default :
				$this->cut_img[0][] = 800;
				$this->cut_img[0][] = 0;
				$this->cut_img[1][] = 400;
				$this->cut_img[1][] = 1;
				$this->cut_img[2][] = 200;
				$this->cut_img[2][] = 0;
				$this->z_type = 'W';
		}
	}
}
