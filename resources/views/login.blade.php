@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/registerForm.js'])
@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\RouteNameField;use App\Lib\Server\CSRF)
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
    <div class="register-frame mb-52">
        <form class="login"
              data-target="#alert"
              data-token="{{(new CSRF(\App\Lib\Utils\RouteNameField::PageLoginPost->value))->get()}}"
              method="POST"
              action="{{ route(RouteNameField::PageLoginPost->value) }}">
            <input type="hidden" name="_token" id="csrf_token" value="{{csrf_token()}}">
            <div class="title">{{$i18N->getLanguage(ELanguageText::login_title)}}</div>
            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !mt-3 !break-keep"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟正確的帳號</li><li class='flex flex-nowrap'>❌最大的長度為255</li>">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_username)}}</label>
                <input class="col form-solid" type="text" name="username" maxlength="255" value="{{old("username")}}"
                       required>
            </div>
            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !break-keep"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟正確的密碼</li><li class='flex flex-nowrap'>❌最小的長度為8</li>">
                <label class="col" for="text4">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <div class="col md:w-fit footer:w-full sm:w-full xs:w-full us:w-full">
                    <div class="form-password-group md:w-fit footer:w-full sm:w-full xs:w-full us:w-full">
                        <input id="text4" class="block form-solid front !w-full" type="password" minlength="8" name="password" autocomplete="password"
                               required>
                        <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                             data-target="#text4"><i class="fa-regular fa-eye"></i></div>
                    </div>
                </div>
            </div>
            <a class="link" href="{{route(RouteNameField::PageForgetPassword->value)}}">忘記密碼</a>
            <a class="link" href="{{route(RouteNameField::PageRegister->value)}}">註冊會員</a>
            <div class="button">
                <button type="submit" disabled class="btn-ripple btn btn-md-strip">{{$i18N->getLanguage(ELanguageText::login_btn)}}</button>
            </div>
            <div id="alert">
                @if ($errors->any())
                    <x-alert type="danger" :messages="$errors->all()"/>
                @endif
            </div>
        </form>
    </div>
@endsection
