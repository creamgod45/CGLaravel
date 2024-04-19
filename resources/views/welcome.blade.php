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
@section('title', '首頁')
@section('content')
    @auth
        {{debugbar()->info($request->user()->permissions)}}
    @endauth
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
            <div class="cards-flex">
                <div class="card">
                    <div class="inner">
                        <div class="title">{{$i18N->getLanguage(ELanguageText::menu_cloudComputing)}}</div>
                        <div class="description">
                            <ul>
                                <li>{{$i18N->getLanguage(ELanguageText::menu_googleCloud)}}</li>
                                <li>{{$i18N->getLanguage(ELanguageText::menu_aws)}}</li>
                                <li>{{$i18N->getLanguage(ELanguageText::menu_MicrosoftAzure)}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="title">目前版面製作中</div>
                <div class="description">請稍待至完成頁面時光臨!!</div>
            </div>
            <div class="close-btn" onclick="document.getElementById('A16H5A').remove()">&times;</div>
        </div>
    </div>
@endsection
