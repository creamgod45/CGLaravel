@vite(['resources/css/app.css', 'resources/js/app.js'])
@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\RouteNameField)
@php
    /***
     * @var string[] $urlParams
     * @var array $moreParams
     * @var I18N $i18N
     * @var Request $request
     * @var string $fingerprint
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::login_title))
@section('content')
    <div class="register-frame">
        <form class="register ct" data-fn="login-submit" data-target="#alert" method="POST" action="{{ route(RouteNameField::PageLoginPost->value) }}">
            @csrf
            <div class="title">{{$i18N->getLanguage(ELanguageText::login_title)}}</div>
            <div class="row !mt-2">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_username)}}</label>
                <input class="col form-solid" type="text" name="username" value="{{old('username')}}" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <input class="col form-solid" type="password" name="password" required>
            </div>
            <a class="link" href="{{route(RouteNameField::PageForgetPassword->value)}}">忘記密碼</a>
            <a class="link" href="{{route(RouteNameField::PageRegister->value)}}">註冊會員</a>
            <div class="button">
                <button type="submit" class="btn-ripple btn btn-md-strip">{{$i18N->getLanguage(ELanguageText::login_btn)}}</button>
            </div>
            <div id="alert">
                @if ($errors->any())
                    <x-alert type="danger" :messages="$errors->all()"/>
                @endif
            </div>
        </form>
    </div>
@endsection
