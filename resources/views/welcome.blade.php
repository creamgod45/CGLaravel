@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Permission\cases\AdministratorPermission;use App\Lib\Utils\Htmlv2;use Illuminate\Support\Facades\Log)
@php
    /***
     * @var string[] $router \
     * @var I18N $i18N
     * @var \Illuminate\Support\Facades\Request $request
     */
    $menu=true;
    $footer=true;
@endphp
@extends('layouts.default')
@section('title', $i18N->getLanguage(ELanguageText::menu_frontpage))
@section('content')
    <main class="container1">
        @env('local')
            @php
                debugbar()->info($request->user())
            @endphp
        @endenv
        <div class="home">
            <div class="btn-demo">
                這裡是關於Button示範
                <div class="btn-group">
                    <div class="btn btn-ok">按鈕</div>
                    <div class="btn btn-cancel">按鈕</div>
                    <div class="btn btn-warning">按鈕</div>
                    <div class="btn btn-error">按鈕</div>
                </div>
                <div class="btn">按鈕</div>
                <div class="btn btn-ok">按鈕</div>
                <div class="btn btn-cancel">按鈕</div>
                <div class="btn btn-warning btn-bold">按鈕</div>
                <div class="btn btn-error btn-max btn-center btn-ripple">按鈕</div>
                <div class="btn btn-color1 btn-md">按鈕</div>
                <div class="btn btn-color2 btn-md-strip">按鈕</div>
                <div class="btn btn-color3">按鈕</div>
                <div class="btn btn-color4">按鈕</div>
                <div class="btn btn-color5">按鈕</div>
                <div class="btn btn-color6">按鈕</div>
                <div class="btn-color1 btn-ripple btn-circle"><i class="fa-solid fa-house"></i></div>
                <button class="btn btn-ripple btn-color1">Click Me</button>
            </div>
            <div class="tooltip-demo">
                <div>
                    這裡是關於Tooltip 示範
                    <span
                        class="tooltip-gen tooltip-bottom-left-to-right tooltip-black tooltip-top-drill-line tooltip-bottom-line tooltip-y-offset-1"
                        data-direction="tooltip-top"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 top</span>
                    <span
                        class="tooltip-gen tooltip-right-to-left tooltip-top-line tooltip-bottom-dashed-line tooltip-y-offset-2 tooltip-white"
                        data-direction="tooltip-left"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 left</span>
                    <span
                        class="tooltip-gen tooltip-bottom-right-to-left tooltip-bottom-drill-line tooltip-y-offset-3 tooltip-top-dashed-line tooltip-warning"
                        data-direction="tooltip-right"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 right</span>
                    <span
                        class="tooltip-gen tooltip-success"
                        data-direction="tooltip-bottom"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 bottom</span>
                </div>
            </div>
            這裡是關於Pagination示範
            <div class="pagination-frame">
                <div class="pagination">
                    <div class="previous active item-btn">
                        <a href=""
                           rel="prev"
                           aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}">
                            {{$i18N->getLanguage(ELanguageText::pagination_previous)}}
                        </a>
                    </div>
                    <div class="item item-btn">
                        <a href="">1</a>
                    </div>
                    <div class="item item-btn">
                        <a href="">2</a>
                    </div>
                    <div class="page-info item-btn">
                        <div>
                            {{$i18N->getLanguage(ELanguageText::pagination_CurrentPage)}}: 1
                        </div>
                        <div>
                            {{$i18N->getLanguage(ELanguageText::pagination_TotalPages)}}: 2
                        </div>
                    </div>
                    <div class="next active item-btn">
                        <a href=""
                           rel="next"
                           aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}">
                            {{$i18N->getLanguage(ELanguageText::pagination_next)}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-demo">
                <div>這是 Card 範例</div>
                <div class="card-list">
                    <div class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">
                                <div class="title">控制項卡片元件</div>
                                <div class="description"></div>
                                <div class="control btn-group">
                                    <div class="btn btn-transition btn-border-0 btn-max btn-text-center btn-md btn-ripple btn-success">確認</div>
                                    <div class="btn btn-transition btn-border-0 btn-max btn-text-center btn-md btn-ripple btn-warning">取消</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                    <div id="card1" class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                </div>
                <div class="cards-flex">
                    <div class="card">
                        <div class="inner">
                            <div class="title"></div>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="inner">
                            <div class="title"></div>
                            <div class="description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
