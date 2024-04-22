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
        @auth
            {{debugbar()->info($request->user()->permissions)}}
        @endauth
    @endenv
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="title">忘記密碼</div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_email)}}</label>
                <input class="col" type="email" name="email" value="{{old("email")}}" required>
            </div>
            <div class="button">
                <button type="submit">{{$i18N->getLanguage(ELanguageText::register_btn)}}</button>
            </div>
            @if(session("status"))
                {{session("status")}}
            @endif
            @if ($errors->any())
                <x-alert type="danger" :messages="$errors->all()" />
            @endif
        </form>
    </div>
    <div class="notification">
        <div id="A16H5A" class="item">
            <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="context">
                <div class="title">{{$i18N->getLanguage(ELanguageText::notification_title)}}</div>
                <div class="description">{{$i18N->getLanguage(ELanguageText::notification_description)}}</div>
            </div>
            <div class="close-btn" onclick="document.getElementById('A16H5A').remove()">&times;</div>
        </div>
    </div>
@endsection
