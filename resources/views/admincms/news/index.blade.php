@extends('layouts.admincms')

@section('content')
    
<div class="row">
    @if($news)
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{$title}}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>标题</th>
                                <th>置顶</th>
                                <th>创建时间</th>
                                <th>修改时间</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $value)
                                <tr>
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->title}}</td>
                                    <td>{{$value->getTop}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->updated_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        
        {{ $news->links() }}
    </div>
    @else
    <no-data></no-data>
    @endif
</div>
@endsection

@section('script')
    {{-- @parent --}}
    <script type="text/javascript">
        
    </script>
@endsection

