@use(App\Lib\Utils\ENotificationType)
<div id="{{"N".Str::random(7)}}" class="item notification-{{$type}}">
    <div class="icon">
        @if($type=== ENotificationType::info)
            <i class="fa-solid fa-info"></i>
        @elseif($type=== ENotificationType::warning)
            <i class="fa-solid fa-triangle-exclamation"></i>
        @elseif($type=== ENotificationType::error)
            <i class="fa-solid fa-xmark"></i>
        @elseif($type=== ENotificationType::success)
            <i class="fa-solid fa-check"></i>
        @endif
    </div>
    <div class="context">
        <div class="title">{!! $title !!}</div>
        <div class="description">{!! $description !!}</div>
    </div>
    <div class="close-btn">&times;</div>
</div>
