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
@section('title', '首頁')
@section('content')
    <div class="home">
        <div class="banner lazy-loaded-image" data-src="{{asset("assets/images/welcome_banner1.jpg")}}">
            <div class="row">
                <div class="col left">
                    <div class="box">
                        <div class="title">{{$i18N->getLanguage(ELanguageText::welcome_title)}}</div>
                        <div class="description">{{$i18N->getLanguage(ELanguageText::welcome_description)}}</div>
                    </div>
                </div>
                <div class="col right">
                    <div class="card">
                        <div class="card"></div>
                    </div>
                </div>
            </div>
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
        <div id="A16H5B" class="item">
            <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="context">
                <div class="title">目前版面製作中</div>
                <div class="description">請稍待至完成頁面時光臨!!</div>
            </div>
            <div class="close-btn" onclick="document.getElementById('A16H5B').remove()">&times;</div>
        </div>
    </div>
@endsection
