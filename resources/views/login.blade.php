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
@section('title', '登入')
@section('content')
    <div class="register-frame">
        <form class="register" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="title">登入</div>
            <div class="row">
                <label class="col">帳號</label>
                <input class="col" type="text" name="username" required>
            </div>
            <div class="row">
                <label class="col">密碼</label>
                <input class="col" type="password" name="password" required>
            </div>
            <div class="button">
                <button type="submit">登入</button>
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
