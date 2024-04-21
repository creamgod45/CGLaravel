@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\Htmlv2;use Illuminate\Pagination\LengthAwarePaginator)
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
    </div>
    @env('local')
        {{debugbar()->info($user->permissions)}}
    @endenv
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
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-pagination>
@endsection

