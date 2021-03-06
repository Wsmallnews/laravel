<?php namespace App\Repositories;

use App\Contracts\Hp as HpContract;
use App\Setting;
use Session;

class Hp implements HpContract {

	private $log_data = array();

	public function l_web(){
		return Setting::find(1);
	}


	public function rt($info = '',$status = 0){
	    $r['info'] = $info;

	    if(empty($info)){
	        $r['info'] = $status ? '操作成功' : '操作失败';
	    }

	    $r['status'] = $status;

	    return $r;
	}


	// 获取二维数组中某一项的集合
	public function str_array_column($data, $field){
	    $egt_5_5 = version_compare(PHP_VERSION,'5.5.0','>=');
	    if ($egt_5_5) {
	        $fields = array_column($data, $field);
	    } else {
	        $fields = array_reduce($data, create_function('$v,$w', '$v[]=$w["'.$field.'"];return $v;'));
	    }
	    return $fields;
	}

	/*
		保留小数
	 */
	public function str_float($float,$bit = 2){
		$accuracy = "%.".$bit."f";
		return sprintf($accuracy, $float);
	}


	public function mitime($bit = 3){
		$time = explode(' ',microtime());
		$accuracy = "%.".$bit."f";

		$float_time = sprintf($accuracy, $time[1].$time[0]);

		return str_replace('.','',$float_time);
	}


}
