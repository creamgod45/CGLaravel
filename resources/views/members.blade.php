@vite(['resources/css/members.css', 'resources/js/members.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use Illuminate\Contracts\Pagination\LengthAwarePaginator)
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
    $members = $moreParams['members'];
@endphp
@extends('layouts.default')
@section('title', "會員資料")
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

