@extends('desktop.layouts.app')

@section('content')
<div class="rows">
    <div class="col-lg-12">
        <div class="panel panel-default shadow">
            <div class="panel-heading">添加主题</div>
            <div class="panel-body">
                <form role="form" method="POST" action="">
                    {{ csrf_field() }}
                    <markdown></markdown>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">
                            注册
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
