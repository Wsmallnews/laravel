<?php

namespace App\Http\Controllers\Desktop;

use Illuminate\Http\Request;
use Auth;
use Cache;
// use Smallnews\Cos\QCloudCos;
use Storage;
use Illuminate\HTTP\File;
use Image;
use MyUpload;

class IndexController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
        // print_r(app('config')->get('qcloud'));
        // print_r($config);
        // exit;
        // $a = Image::make('storage/avatars/20170324/149033866201602757.png');
        // 
        // echo hash_file('sha1', $a->encode());
        // exit;
        // $b = $a->encode()->filesize();
        // print_r($b);
        // 
        // echo filesize($a->encode());
        // 
        // echo "-----------------------------------------------------------------------";
        // $c = file_get_contents('storage/avatars/20170324/149033866201602757.png');
        // 
        // $d = filesize($c);
        // print_r($d);
        // exit;
        // 
        // $a = QCloudCos::getAppId();
        // $b = app('qcloudcos')->listFolder('smallnews','/');
        // print_r($b);
        // print_r($a);exit;
        // 
        // // print_r(new File('images/elite.png'));exit;
        // // print_r(config('filesystems.disks.qcos'));exit;
        // // $disk = Storage::disk('public');
        // // $exists = $disk->getMetadata('avatars/20170324/149033866201602757.png');
        // 
        // $disk = Storage::disk('qcos');
        // $exists = $disk->put('1234567.png', 'storage/avatars/20170324/149033866201602757.png');
        // 
        // 
        // print_r($exists);exit;
        // $a = QCloudCos::createFolder('smallnews', 'test');
        // print_r($a);exit;
        // if(Cache::has('smallnews')){
        //     echo Cache::get('smallnews');
        // }else{
        //     Cache::put('smallnews','hello world', '6000');
        //     echo "The cache has been written to redis";
        // }
        // exit;
        // print_r(Auth::user());
        return view('desktop.index');
    }
    
    
    public function upload(Request $request){
        if ($request->hasFile('FileContent')){
            $result = MyUpload::upload($request->file('FileContent'), $request->input('file_type', 'avatars'));
            $result['filename'] = $result['data']['url'];
        }else {
            $result = [
                'error' => 1,
                'info' => '文件不存在'
            ];
        }

        return response()->json($result);
    }
    
    
    public function fileTest($filename = ''){   // 可以上传成功，但是超级慢
        // $url = "/public/".$filename;
        // 
        // $result = Storage::disk('local')->get($url);
        // 
        // // $img = Image::make(file_get_contents($url));
        // $img = Image::make($result);
        // $img->fit(50, 50);
        // 
        // // $save_tmp_path = public_path().'/tmp_file/2222.jpeg';
        // 
        // // $img->save($save_tmp_path);     // 保存到临时文件夹
        // // echo $save_tmp_path;
        // Storage::disk('local')->put('/tmp_file/1111.jpg', $img->encode());
        // exit;
        $fileid = 'sample123';
        $expired = time() + 999999;
        $url = \Tencentyun\ImageV2::generateResUrl('smalltest', 0, $fileid);
        $sign = \Smallnews\Cos\Auth::createReusableSignature($expired, 'smalltest');
        
        // echo $sign;
        $ret = array('url' => $url,'sign' => $sign);
        exit(json_encode($ret));
        exit;
        
        $fileid = 'sample123';                              // 自定义文件名
        //生成新的上传签名
        $expired = time() + 999;
        $sign = \Tencentyun\Auth::getAppSignV2('smalltest', $fileid, $expired);
        $ret = array('url' => $url,'sign' => $sign);
        exit(json_encode($ret));

        
        // $contents = file_get_contents("http://onguivs9z.bkt.clouddn.com/QQ%E5%9B%BE%E7%89%8720160715121751.jpg");
        $contents = file_get_contents("http://smalltest-1252018639.picsh.myqcloud.com/avatars/20170415/98de34446ea23a3ff2257ad638216fe0.jpeg");
        echo $contents;exit;
        // $url = "/public/".$filename;
        
        $result = Storage::disk('qcos')->get($filename);
        
        // $img = Image::make(file_get_contents($url));
        $img = Image::make($result);
        $img->fit(50, 50);
        
        // $save_tmp_path = public_path().'/tmp_file/2222.jpeg';
        
        // $img->save($save_tmp_path);     // 保存到临时文件夹
        // echo $save_tmp_path;
        Storage::disk('local')->put('/tmp_file/qcos.jpg', $img->encode());
        exit;
        
        
        
        var_dump($img);exit;
        // echo $filename;
        print_r(request()->all());exit;
        return view('desktop.fileTest');
    }
}
