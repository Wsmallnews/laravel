@extends('desktop.layouts.app')

@section('title-body')
    {{ $user->name }} - 
@endsection

@section('content')

<div class="rows">
    <div class="col-lg-3">
        @include('desktop.users.userMenu')
    </div>
    
    <div class="col-lg-9 pd-left pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">{{$title}}</div>
            <div class="panel-body">
                <form role="form" method="POST" action="{{ route('user.update', ['id' => $user->id]) }}" id="user_form" >
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH" >
                    <div style="display:none;">
                        <uploader btn-obj="hidden" btn-name="hidden" type="no"  ></uploader>
                    </div>
                    <div class="form-group">
                        <uploader btn-obj="avatar" btn-name="更改头像" type="users/avatars"  @if (old('avatar')) def-value="{{old('avatar')}}" @else def-value="{{ $user->avatar }}" @endif></uploader>
                    </div>
                    
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="请填写手机号" 
                            @if(old('phone')) value="{{old('phone')}}" @else value="{{$user->phone}}" @endif>
                        
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group{{ $errors->has('personal_website') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" id="personal_website" name="personal_website" placeholder="请填写个人网站地址" 
                            @if(old('personal_website')) value="{{old('personal_website')}}" @else value="{{$user->personal_website}}" @endif >
                        
                        @if ($errors->has('personal_website'))
                            <span class="help-block">
                                <strong>{{ $errors->first('personal_website') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <uploader btn-obj="wechat_qrcode" btn-name="更改微信二维码" type="users/qrcode"  @if (old('wechat_qrcode')) def-value="{{old('wechat_qrcode')}}" @else def-value="{{ $user->wechat_qrcode }}" @endif></uploader>
                    </div>
                    
                    <div class="form-group">
                        <uploader btn-obj="qq_qrcode" btn-name="更改qq二维码" type="users/qrcode"  @if (old('qq_qrcode')) def-value="{{old('qq_qrcode')}}" @else def-value="{{ $user->qq_qrcode }}" @endif></uploader>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="linked_in" name="linked_in" placeholder="请填写领英个人主页" 
                            @if(old('linked_in')) value="{{old('linked_in')}}" @else value="{{$user->linked_in}}"@endif >
                    </div>
                    
                    <div class="form-group">
                        <input type="text" class="form-control" id="company" name="company" placeholder="请填写公司名称" 
                            @if(old('company')) value="{{old('company')}}" @else value="{{$user->company}}" @endif>
                    </div>
                    
                    <div class="form-group">
                        <uploader btn-obj="pay_me" btn-name="更改收款码" type="users/qrcode"  @if (old('pay_me')) def-value="{{old('pay_me')}}" @else def-value="{{ $user->pay_me }}" @endif></uploader>
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
    <script type="text/javascript">
        
    </script>
@endsection
