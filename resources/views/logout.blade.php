@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use Illuminate\Http\Request)
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
@section('title', $i18N->getLanguage(ELanguageText::logout_title))
@section('content')
    <div class="register-frame">
        <div class="login">
            <div class="title">{{$i18N->getLanguage(ELanguageText::logout_title)}}</div>
            <a href="/login"
               class="context">{{$i18N->getLanguage(ELanguageText::logout_context, true)->Replace("%s%", 5)->toString()}}
                ID:{{Cache::get('guest_id'.$request->fingerprint())}}</a>
        </div>
    </div>
    <script>
        setTimeout(() => location.assign("/login"), 5000);
    </script>
@endsection
