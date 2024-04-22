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
    <div class="home">
        <div class="banner lazy-loaded-image" data-src="{{asset("assets/images/welcome_banner1.jpg")}}">
            <div class="row">
                <div class="col left">
                    <div class="box">
                        <div class="title">
                            <?= $i18N->getLanguage(ELanguageText::welcome_title, true)
                                ->Replace("%NCSP%",
                                    (new Htmlv2("span"))
                                        ->close(true)
                                        ->newLine(true)
                                        ->body("NCSP")
                                        ->attr("class", "tooltip-gen")
                                        ->attr("data-direction", "tooltip-top")
                                        ->attr(
                                            "data-tooltip",
                                            $i18N->getLanguage(ELanguageText::welcome_title_tooltip)
                                        )
                                        ->build()
                                )
                                ->toString()
                            ?>
                        </div>
                        <div class="description">{{$i18N->getLanguage(ELanguageText::welcome_description)}}</div>
                    </div>
                </div>
                <div class="col right">
                    <div class="card">
                        <div class="item-frame lazy-loaded-image"
                             data-src="{{asset("assets/images/welcome_banner_server1.svg")}}">
                            <div class="item">
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="service lazy-loaded-image" data-src="{{asset("assets/images/welcome_banner2.png")}}">
            <div class="asset2">

            </div>
            <div class="asset1 lazy-loaded-image"
                 data-src="{{asset("assets/images/welcome_banner2_programming.svg")}}"></div>
        </div>
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
        @if(session('invaild') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_invaild_title);
                $description=$i18N->getLanguage(ELanguageText::notification_invaild_description);
                if($errors->any()){
                    foreach ($errors->all() as $item) {
                        $description.="<br>".$item;
                    }
                }
            @endphp
            <div id="a1gk9d8f" class="item">
                <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="context">
                    <div class="title">{{$title}}</div>
                    <div class="description">{!! $description !!}</div>
                </div>
                <div class="close-btn" onclick="document.getElementById('a1gk9d8f').remove()">&times;</div>
            </div>
        @endif
        @if(session('mail') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
                $description="";
                if(session('mail_result') === true){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_description);
                }elseif(session('mail_result') === false){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_fail_description);
                }
            @endphp
            <div id="45a1g89s" class="item">
                <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="context">
                    <div class="title">{{$title}}</div>
                    <div class="description">{{$description}}</div>
                </div>
                <div class="close-btn" onclick="document.getElementById('45a1g89s').remove()">&times;</div>
            </div>
        @endif
        @if(session('mail_result') !== null)
            @php
                $title=$i18N->getLanguage(ELanguageText::notification_email_verifyTitle);
                $description="";
                if(session('mail_result') === 0){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                    $description .= $i18N->getLanguage(ELanguageText::notification_email_InvalidVerificationLink);
                }elseif(session('mail_result') === 1){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_failedAppendText);
                    $description .= $i18N->getLanguage(ELanguageText::notification_email_hasVerifiedEmail);
                }elseif(session('mail_result') === 2){
                    $description = $i18N->getLanguage(ELanguageText::notification_email_markEmailAsVerified);
                }
            @endphp
            <div id="41859ags89" class="item">
                <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="context">
                    <div class="title">{{$title}}</div>
                    <div class="description">{{$description}}</div>
                </div>
                <div class="close-btn" onclick="document.getElementById('41859ags89').remove()">&times;</div>
            </div>
        @endif
    </div>
@endsection
