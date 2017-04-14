@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('content')

<div class="rows">
    <div class="col-lg-3">
        @include('desktop.layouts.userInfo')
    </div>
    
    <div class="col-lg-9 pd-left pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">{{$title}}</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{ route('user.update', ['id' => $user->id]) }}" id="user_form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH" >
                    
                    <div class="form-group">
                        <input type="file" class="form-control" id="avatar" name="avatar" placeholder="请上传头像">
                    </div>
                    
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="请填写手机号" value="@if(old('phone')){{{old('phone')}}}@else{{{$user->phone}}}@endif">
                        
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('personal_website') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="personal_website" name="personal_website" placeholder="请填写个人网站地址" value="@if(old('personal_website')){{{old('personal_website')}}}@else{{{$user->personal_website}}}@endif">
                        
                        @if ($errors->has('personal_website'))
                            <span class="help-block">
                                <strong>{{ $errors->first('personal_website') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <input type="file" class="form-control" id="wechat_qrcode" name="wechat_qrcode" placeholder="请上传微信二维码" value="@if(old('wechat_qrcode')){{{old('wechat_qrcode')}}}@else{{{$user->wechat_qrcode}}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <input type="file" class="form-control" id="qq_qrcode" name="qq_qrcode" placeholder="请上传qq二维码" value="@if(old('qq_qrcode')){{{old('qq_qrcode')}}}@else{{{$user->qq_qrcode}}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="linked_in" name="linked_in" placeholder="请填写领英个人主页" value="@if(old('linked_in')){{{old('linked_in')}}}@else{{{$user->linked_in}}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="company" name="company" placeholder="请填写公司名称" value="@if(old('company')){{{old('company')}}}@else{{{$user->company}}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <input type="file" class="form-control" id="pay_me" name="pay_me" placeholder="请上传向我付款二维码" value="@if(old('pay_me')){{{old('pay_me')}}}@else{{{$user->pay_me}}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="save" class="btn btn-default">
                            保存
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    
@endsection
