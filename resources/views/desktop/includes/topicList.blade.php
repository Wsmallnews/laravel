<ul class="list-group">
    @foreach($topics as $topic)
        <li class="list-group-item list-spec" 
            @if($type == 'all' || $type == 'normal')
            style="
                @if($topic->is_top)
                    background-image: url('/images/top.png');
                @elseif ($topic->is_elite)
                    background-image: url('/images/elite.png');
                @endif
            "
            @endif
        >
            @if($type == 'all')
            <a href="{{ route('user.show', $topic->user_id) }}" class="pjax-element list-a-avatar">
                <img src="{{ $topic->user->avatar }}" class="list-avatar shadow-3" onerror="this.src='/images/no-user.png'"/>
            </a>
            @endif
            
            <div class="list-content">
                <a href="{{ route('topic.show', $topic->id) }}" class="pjax-element list-title">{{ $topic->title }}</a>
            </div>
            
            @if($type == 'all' || $type == 'normal')
            <span class="list-tag hidden-xs">{{$topic->classify->name}}</span>
            <span class="hui-12">{{$topic->published_at->diffForHumans()}}</span>
            <span class="badge">{{$topic->num}}</span>
            @endif
        </li>
    @endforeach
</ul>

@if(!isset($no_paginate))
    {{ $topics->links() }}
@endif

