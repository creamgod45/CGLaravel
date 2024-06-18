@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/registerForm.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Server\CSRF;use Illuminate\Http\Request;use App\Lib\Utils\RouteNameField)
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
@section('title', $i18N->getLanguage(ELanguageText::register_title))
@section('content')
    <div class="register-frame">
        <form class="register" method="POST"
              data-target="#alert"
              data-token="{{(new CSRF(\App\Lib\Utils\RouteNameField::PageRegisterPost->value))->get()}}"
              action="{{ route(\App\Lib\Utils\RouteNameField::PageRegisterPost->value) }}">
            <input type="hidden" name="_token" id="csrf_token" value="{{csrf_token()}}">
            <div class="title">{{$i18N->getLanguage(ELanguageText::register_title)}}</div>
            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !mt-3 !break-keep"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟獨一無二帳號</li><li class='flex flex-nowrap'>❌最大的長度為255</li>">
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
                 data-customclass="min-w-fit md:w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟獨一無二電子信箱</li><li class='flex flex-nowrap'>❌最大的長度為255</li>">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_email)}}</label>
                <input class="col form-solid" type="email" name="email" maxlength="255" value="{{old("email")}}"
                       required>
            </div>
            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !break-keep"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟獨一無二密碼</li><li class='flex flex-nowrap'>❌最小的長度為8</li>">
                <label class="col" for="text4">{{$i18N->getLanguage(ELanguageText::validator_field_password)}}</label>
                <div class="col md:w-fit footer:w-full sm:w-full xs:w-full us:w-full">
                    <div class="form-password-group footer:w-full md:w-fit sm:w-full xs:w-full us:w-full">
                        <input id="text4" class="block form-solid front !w-full" type="password" minlength="8" name="password" autocomplete="new-password"
                               required>
                        <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                             data-target="#text4"><i class="fa-regular fa-eye"></i></div>
                    </div>
                </div>
            </div>

            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !break-keep"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[42%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟確認密碼</li><li class='flex flex-nowrap'>❌最小的長度為8</li>">
                <label class="col" for="text5">{{$i18N->getLanguage(ELanguageText::validator_field_passwordConfirmed)}}</label>
                <div class="col md:w-fit footer:w-full sm:w-full xs:w-full us:w-full">
                    <div class="form-password-group md:w-fit footer:w-full sm:w-full xs:w-full us:w-full">
                        <input id="text5" class="block form-solid front !w-full" type="password" minlength="8" name="password_confirmation" autocomplete="new-password"
                               required>
                        <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                             data-target="#text5"><i class="fa-regular fa-eye"></i></div>
                    </div>
                </div>
            </div>
            <div class="row tooltip-gen tooltip-right-to-left tooltip-error !break-keep form-group"
                 data-direction="tooltip-right"
                 data-mobile="tooltip-bottom"
                 data-mobileTriggerPx="1138"
                 data-htmlable="true"
                 data-hoverable="false"
                 data-customclass="min-w-fit w-[45%] footer:w-[55%] !block"
                 data-tooltip="<li class='flex flex-nowrap'>⭕必填項目</li><li class='flex flex-nowrap'>🌟獨一無二電話號碼</li><li class='flex flex-nowrap'>⭕收發簡訊的號碼</li><li class='flex flex-nowrap'>❌最小的長度為10</li>">
                <label class="col">{{$i18N->getLanguage(ELanguageText::validator_field_phone)}}</label>
                <div class="col md:max-w-[60%] !block">
                    <input type="tel" class="form-solid ITI !w-full" name="phone" autocomplete="phone" data-autotrigger="true"
                           data-msg="#phone-Validator-msg" data-true="ok" data-false="failed" required>
                    <span id="phone-Validator-msg" class="hidden"></span>
                </div>
            </div>
            <a class="link" href="{{route(RouteNameField::PageLogin->value)}}">登入會員</a>
            <div class="button">
                <button type="submit"
                        disabled
                        class="btn btn-ripple btn-md-strip">{{$i18N->getLanguage(ELanguageText::register_btn)}}</button>
            </div>
            <div id="alert">
                @if ($errors->any())
                    <x-alert type="danger" :messages="$errors->all()"/>
                @endif
            </div>
        </form>
    </div>
@endsection
