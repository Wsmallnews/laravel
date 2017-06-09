@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('style')
<style type="text/css">

</style>
@endsection

@section('content')
<div class="rows">
    <div class="col-lg-3">
        @include('desktop.users.userMenu')
    </div>
    
    <div class="col-lg-9 pd-left pd-no">
        <div class="alert alert-info" role="alert">欢迎来到管理中心</div>
        
        <div class="panel panel-default shadow">
            <div class="panel-heading">{{$title}}</div>
            <div class="panel-body">
                <button type="button" name="upload_test" class="btn btn-default upload_asset">
                    上传资源文件(测试)
                </button>
                
                <button type="button" name="upload" class="btn btn-default upload_asset">
                    上传资源文件(正式)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(".upload_asset").on('click', function(){
            var type = $(this).attr('name') == 'upload' ? "correct" : "";
            
            showAlert({
                title:'确定要上传吗？'
            },
            function(){
                Vue.http.post("{{ route('admin.uploadAsset') }}", {_token: Laravel.csrfToken, type:type}).then(function(response) {
                    $("#save_topic").html('保存成功').fadeOut(3000);
                });
            });
        })
        
    </script>
@endsection
