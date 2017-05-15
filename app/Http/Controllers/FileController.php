<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use MyUpload;

class FileController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * 文件上传
     * @author @smallnews 2017-05-15
     * @param  Request $request [description]
     * @return [type]           [description]
     */
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
}
