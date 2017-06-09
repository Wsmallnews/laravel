<div class="list-group shadow">
    <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="list-group-item {{ Route::currentRouteName() == 'user.edit' ? 'active' : ''}} ">资料修改</a>
    <a href="{{ route('user.bind') }}" class="list-group-item {{ Route::currentRouteName() == 'user.bind' ? 'active' : ''}}">账号绑定</a>
    @if (Auth::user()->isSuperAdmin()) 
        <a href="{{ route('user.admin') }}" class="list-group-item {{ Route::currentRouteName() == 'user.admin' ? 'active' : ''}}">管理中心</a>
    @endif
    {{-- <a href="#" class="list-group-item">Morbi leo risus</a> --}}
</div>