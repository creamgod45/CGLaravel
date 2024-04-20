@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::logout_title))
@section('content')
    <div class="register-frame">
        <div class="login">
            <div class="title">{{$i18N->getLanguage(ELanguageText::logout_title)}}</div>
            <a href="/login" class="context">{{$i18N->getLanguage(ELanguageText::logout_context)}}</a>
        </div>
    </div>
    <script>
        setTimeout(() => location.assign("/login"), 3000);
    </script>
@endsection
