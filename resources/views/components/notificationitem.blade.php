@use(App\Lib\Utils\ENotificationType)
@php
    $id = "N".Str::random(7);
@endphp
<div id="{{$id}}" data-seconds="{!! $millisecond !!}" class="item notification-{{$type->name}}">
    @if($millisecond !== 4900)
    <style>
        .notification #{{$id}}::after{
            animation: notificationtimeline {{$millisecond-200}}ms ease-in-out !important;
        }
    </style>
    @endif
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
