@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\I18N)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', '註冊')
@section('content')
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="title">註冊</div>
            <div class="row">
                <label class="col">帳號</label>
                <input class="col" type="text" name="username" required>
            </div>
            <div class="row">
                <label class="col">信箱</label>
                <input class="col" type="email" name="email" required>
            </div>
            <div class="row">
                <label class="col">密碼</label>
                <input class="col" type="password" name="password" required>
            </div>
            <div class="row">
                <label class="col">確認密碼</label>
                <input class="col" type="password" name="password_confirmation" required>
            </div>
            <div class="row">
                <label class="col">電話</label>
                <input class="col" type="password" name="phone" required>
            </div>
            <div class="button">
                <button type="submit">註冊會員</button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
@endsection
