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
            <div class="button">
                <button type="submit">{{$i18N->getLanguage(ELanguageText::login_btn)}}</button>
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
