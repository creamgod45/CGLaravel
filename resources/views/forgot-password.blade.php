@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\RouteNameField)
@vite(['resources/css/app.css', 'resources/js/app.js'])
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
@section('title', $i18N->getLanguage(ELanguageText::menu_frontpage))
@section('content')
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route(RouteNameField::PageForgetPasswordPost->value) }}">
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
@endsection
