@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use Illuminate\Contracts\Pagination\LengthAwarePaginator)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     * @var LengthAwarePaginator $members
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::menu_frontpage))
@section('content')
    <main class="container1">
        <div class="home">
            <x-pagination :i18N="$i18N" :elements="$members">
                <table class="table table-row-hover table-striped">
                    <thead>
                    <tr>
                        <th>ID<span><i class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_username)}} <span><i
                                    class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_email)}} <span>
                        <i class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_phone)}} <span>
                        <i class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_enable)}} <span>
                        <i class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_administrator)}} <span><i
                                    class="fa-solid fa-sort-down"></i></span></th>
                        <th>{{$i18N->getLanguage(ELanguageText::validator_field_email_verified_at)}} <span><i
                                    class="fa-solid fa-sort-down"></i></span></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <th>{{ $member->id }}</th>
                            <th>{{ $member->username }}</th>
                            <th>{{ $member->email }}</th>
                            <th>{{ $member->phone }}</th>
                            <th>{{ $member->enable }}</th>
                            <th>{{ $member->administrator }}</th>
                            <th>{{ $member->email_verified_at }}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </x-pagination>
        </div>
    </main>
@endsection

