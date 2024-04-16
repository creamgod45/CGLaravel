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
    hello
@endsection
