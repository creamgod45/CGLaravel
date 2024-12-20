@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\Htmlv2;use Illuminate\Support\Facades\Log)
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
        <form class="register" method="POST" action="{{ route(\App\Lib\Utils\RouteNameField::PagePasswordResetPost->value) }}">
            @csrf
            <div class="title">重設密碼</div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <input class="col" type="password" name="password" autocomplete="new-password" required>
            </div>
            <div class="row">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_passwordConfirmed)}}</label>
                <input class="col" type="password" name="password_confirmation" required>
            </div>
            <input type="hidden" name="email" value="{{$moreParams['email']}}">
            <input type="hidden" name="token" value="{{$moreParams['token']}}">
            <div class="button">
                <button type="submit">{{$i18N->getLanguage(ELanguageText::register_btn)}}</button>
            </div>
            @if ($errors->any())
                <x-alert type="danger" :messages="$errors->all()" />
            @endif
        </form>
    </div>
@endsection
