@vite(['resources/css/app.css', 'resources/js/app.js'])
@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::login_title))
@section('content')
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="title">{{$i18N->getLanguage(ELanguageText::login_title)}}</div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_username)}}</label>
                <input class="col" type="text" name="username" value="{{old('username')}}" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <input class="col" type="password" name="password" required>
            </div>
            <a class="link" href="{{route('password.request')}}">忘記密碼</a>
            <a class="link" href="{{route('member.form-register')}}">註冊會員</a>
            <div class="button">
                <button type="submit">{{$i18N->getLanguage(ELanguageText::login_btn)}}</button>
            </div>
            @if ($errors->any())
                <x-alert type="danger" :messages="$errors->all()"/>
            @endif
        </form>
    </div>
@endsection
