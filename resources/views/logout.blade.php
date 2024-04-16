@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\I18N);
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
    <div class="register-frame">
        <div class="login">
            <div class="title">登出</div>
            <div class="context">已經登出三秒後跳轉頁面!!</div>
        </div>
    </div>
@endsection
