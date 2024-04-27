<div id="{{$id}}" class="item notification-{{$type->name}}">
    <div class="icon">
        @if($type===\App\Lib\Utils\ENotificationType::info)
            <i class="fa-solid fa-info"></i>
        @elseif($type===\App\Lib\Utils\ENotificationType::warning)
            <i class="fa-solid fa-triangle-exclamation"></i>
        @elseif($type===\App\Lib\Utils\ENotificationType::error)
            <i class="fa-solid fa-xmark"></i>
        @elseif($type===\App\Lib\Utils\ENotificationType::success)
            <i class="fa-solid fa-check"></i>
        @endif
    </div>
    <div class="context">
        <div class="title">{!! $title !!}</div>
        <div class="description">{!! $description !!}</div>
    </div>
    <div class="close-btn">&times;</div>
</div>
