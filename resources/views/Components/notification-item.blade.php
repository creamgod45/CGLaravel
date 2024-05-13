<div id="{{"N".Str::random(7)}}" class="item notification-{{$type->name}}">
    <div class="icon">
        @if($type=== "info")
            <i class="fa-solid fa-info"></i>
        @elseif($type=== "warning")
            <i class="fa-solid fa-triangle-exclamation"></i>
        @elseif($type=== 'error')
            <i class="fa-solid fa-xmark"></i>
        @elseif($type=== "success")
            <i class="fa-solid fa-check"></i>
        @endif
    </div>
    <div class="context">
        <div class="title">{!! $title !!}</div>
        <div class="description">{!! $description !!}</div>
    </div>
    <div class="close-btn">&times;</div>
</div>
