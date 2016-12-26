@extends('layouts.admincms')

@section('title', '资讯列表')

@section('content')
    
<div class="row">
    {{-- <router-link to="{{Route::currentRouteName()}}/table">Go to Foo</router-link>
    <router-link to="{{route('admin.index')}}/example">Go to Bar</router-link>
    
    <router-view></router-view> --}}
    {{-- <admintable :grid-data="gridData" :grid-columns="gridColumns" :title="title" ></admintable> --}}
    
    {{-- <example :message="msg"></example> --}}
</div>

@endsection

@section('script')
    {{-- @parent --}}
    
    <script type="text/javascript">
    
    // var router = new VueRouter({
    //     mode: 'history',
    //     routes: [
    //         {
    //             path: "{{route('admin.index')}}/table",
    //             component: admin_table
    //         },
    //         {
    //             path: '{{route('admin.index')}}/example',
    //             component: example
    //         },
    //         {
    //             path: '{{route('admin.index')}}/example',
    //             component: example
    //         }
    //     ]
    // })
    // 
    // var app = new Vue({
    //     
    // });
    // 
    
    var Vm = new Vue({
        el : '#wrapper',
        // router: router,
        data : {
            gridColumns: ['title', 'content'],
            gridData: [],
            apiUrl:"{{ url('admincms/newslist') }}",
            articles: [],
            title: "hello world"
        },
        mounted: function(){
            var _this = this;
            // _this.$Progress.start();
            _this.$http.get(this.apiUrl).then(function(response) {
                // _this.$Progress.finish();
                // 这里是处理正确的回调
                console.log(response.data);
                _this.gridData = response.data.data
            }, function(response) {
                // _this.$Progress.fail();
                // 这里是处理错误的回调
                console.log(response)
            });
        },
        components : {
            'admintable': admin_table
        }
    });
    // }).$mount('#wrapper');
    </script>

@endsection

