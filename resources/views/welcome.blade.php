@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Permission\cases\AdministratorPermission;use App\Lib\Utils\Htmlv2;use Illuminate\Support\Facades\Log)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     * @var \Illuminate\Support\Facades\Request $request
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::menu_frontpage))
@section('content')
    @env('local')
        @php
            debugbar()->info($request->user())
        @endphp
    @endenv
    <div class="home">
        <div class="a456sgt">
            <div class="btn-group">
                <div class="btn btn-ok">按鈕</div>
                <div class="btn btn-cancel">按鈕</div>
                <div class="btn btn-warning">按鈕</div>
                <div class="btn btn-error">按鈕</div>
            </div>
            <div class="btn">按鈕</div>
            <div class="btn btn-ok">按鈕</div>
            <div class="btn btn-cancel">按鈕</div>
            <div class="btn btn-warning btn-bold">按鈕</div>
            <div class="btn btn-error btn-max btn-center">按鈕</div>
            <div class="btn btn-color1">按鈕</div>
            <div class="btn btn-color2">按鈕</div>
            <div class="btn btn-color3">按鈕</div>
            <div class="btn btn-color4">按鈕</div>
            <div class="btn btn-color5">按鈕</div>
            <div class="btn btn-color6">按鈕</div>
        </div>
    </div>
    <div class="notification">
        <x-notification-item id="A16H5A" :title="$i18N->getLanguage(ELanguageText::notification_title)" :description="$i18N->getLanguage(ELanguageText::notification_description)" :type="\App\Lib\Utils\ENotificationType::warning" />
        @if(session('invaild') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_invaild_title);
                $description=$i18N->getLanguage(ELanguageText::notification_invaild_description);
                if($errors->any()){
                    foreach ($errors->all() as $item) {
                        $description.="<br>".$item;
                    }
                }
            @endphp
            <x-notification-item :type="\App\Lib\Utils\ENotificationType::error" :title="$title" :description="$description" />
        @endif
        @if(session('mail') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
                $description="";
                $type=\App\Lib\Utils\ENotificationType::info;
                if(session('mail') === true){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_description);
                    $type=\App\Lib\Utils\ENotificationType::success;
                }elseif(session('mail') === false){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_fail_description);
                    $type=\App\Lib\Utils\ENotificationType::error;
                }
            @endphp
            <x-notification-item :type="$type" :title="$title" :description="$description" />
        @endif
        @if(session('mail_result') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
                $description="";
                $type=\App\Lib\Utils\ENotificationType::info;
                if(session('mail_result') === 0){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                    $description .= $i18N->getLanguage(ELanguageText::notification_email_InvalidVerificationLink);
                    $type=\App\Lib\Utils\ENotificationType::error;
                }elseif(session('mail_result') === 1){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                    $description .= $i18N->getLanguage(ELanguageText::notification_email_hasVerifiedEmail);
                    $type=\App\Lib\Utils\ENotificationType::warning;
                }elseif(session('mail_result') === 2){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_markEmailAsVerified);
                    $type=\App\Lib\Utils\ENotificationType::success;
                }
            @endphp
            <x-notification-item :type="$type" :title="$title" :description="$description" />
        @endif
    </div>
@endsection
