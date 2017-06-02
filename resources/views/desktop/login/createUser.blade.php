@extends('desktop.layouts.app')

@section('content')
<div class="rows">
    <div class="col-lg-3">
        <div class="shadow mr-bo-20">asdfasdfasdf</div>
    </div>
    <div class="col-lg-9 pd-left pd-no">
        <div class="panel panel-default shadow">
            <div class="panel-heading">Register</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/createUser') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="driver" @if (old('driver')) value="{{old('driver')}}" @else value="{{ session('driver') }}" @endif>
                    <input type="hidden" name="token" @if (old('token')) value="{{old('token')}}" @else value="{{ session('socialiteUser.token') }}" @endif>
                    <div class="form-group">
                        <label for="avatar" class="col-md-4 control-label">头像</label>
                        <div class="col-md-6">
                            <uploader btn-obj="avatar" btn-name="更改头像" type="users/avatars"  @if (old('avatar')) def-value="{{old('avatar')}}" @else def-value="{{ session('socialiteUser.avatar') }}" @endif></uploader>
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">用户名</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="" @if (old('name')) value="{{old('name')}}" @else value="{{ session('socialiteUser.nickname') }}" @endif>
                            
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-4 control-label">邮箱</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="" @if (old('email')) value="{{old('email')}}" @else value="{{ session('socialiteUser.email') }}" @endif>
                            
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">密码</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password" name="password" placeholder="">
                            
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="col-md-4 control-label">确认密码</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="">
                            
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-default">
                                注册
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    
    
@endsection
