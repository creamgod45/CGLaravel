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
                    <div class="title">{{$i18N->getLanguage(ELanguageText::welcome_title)}}</div>
                    <div
                        class="description">{{$i18N->getLanguage(ELanguageText::placeholder_memberHelloText, true)->Replace("%name%", $user['username'])->toString()}}</div>
                </div>
                <div class="col right"></div>
            </div>
        </div>
    </div>
@endsection

