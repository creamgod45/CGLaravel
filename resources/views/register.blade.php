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
@section('title', '註冊')
@section('content')
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="title">{{$i18N->getLanguage(ELanguageText::register_title)}}</div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_username)}}</label>
                <input class="col" type="text" name="username" value="{{old("username")}}" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_email)}}</label>
                <input class="col" type="email" name="email" value="{{old("email")}}" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <input class="col" type="password" name="password" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_passwordConfirmed)}}</label>
                <input class="col" type="password" name="password_confirmation" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_phone)}}</label>
                <input class="col" type="password" name="phone" value="{{old("phone")}}" required>
            </div>
            <div class="button">
                <button type="submit">{{$i18N->getLanguage(ELanguageText::register_btn)}}</button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
@endsection
