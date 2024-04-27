@vite(['resources/css/app.css', 'resources/js/app.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Permission\cases\AdministratorPermission;use App\Lib\Utils\Htmlv2;use App\Lib\Utils\Utilsv2;use Illuminate\Support\Facades\Log)
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
                debugbar()->info($request->user());
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
                <div class="btn btn-border-0 btn-ripple btn-warning btn-bold">按鈕</div>
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
                <div class="placeholder ">
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
                        class="tooltip-gen tooltip-bottom-right-to-left tooltip-bottom-drill-line tooltip-y-offset-3 tooltip-top-dashed-line tooltip-color1"
                        data-direction="tooltip-right"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 right</span>
                    <span
                        class="tooltip-gen tooltip-success"
                        data-direction="tooltip-bottom"
                        data-tooltip="Tooltip test 45a89sd9as4 89fas94f9as f">測試訊息 bottom</span>
                </div>
            </div>
            這裡是關於Pagination示範
            <div class="btn-group btn-group-border-2-slate">
                <a class="btn btn-md btn-dead tracking-widest !bg-color1 btn-border-0">1/1</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0"><i class="fa-solid fa-left-long"></i></a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0">1</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0">2</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0">3</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0"><i class="fa-solid fa-right-long"></i></a>
            </div>
            <div class="pagination-frame">
                <div class="pagination placeholder">
                    <div class="previous active item-btn">
                        <a href=""
                           rel="prev"
                           aria-label="{{$i18N->getLanguage(ELanguageText::pagination_previous)}}">
                            <i class="fa-solid fa-left-long"></i>
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
                            1/ 1
                        </div>
                    </div>
                    <div class="next active item-btn">
                        <a href=""
                           rel="next"
                           aria-label="{{$i18N->getLanguage(ELanguageText::pagination_next)}}">
                            <i class="fa-solid fa-right-long"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-demo">
                <div>這是 Card 範例</div>
                <div class="card-list !gap-10">
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">
                                <div class="center-border">
                                    <div class="title">CGPHP01</div>
                                    <div class="description">這是團隊歷經3年時間開發的產品，結合市場回饋經驗所以這設計的內容。</div>
                                    <div class="persons-circle-bar">
                                        <div class="persons-title">開發人員</div>
                                        <div class="flex-center-box">
                                            <div class="pcb-item placeholder placeholder-circle lazyImg" data-src="{{asset('assets/images/people1.webp')}}"></div>
                                            <div class="pcb-item placeholder placeholder-circle lazyImg" data-src="{{asset('assets/images/people2.webp')}}"></div>
                                        </div>
                                    </div>
                                    <div class="flex-text-col">
                                        <div class="ftc-item">
                                            <div class="highlight">4.5&starf;</div>
                                            <div class="ftc-title">評分</div>
                                        </div>
                                        <div class="ftc-item">
                                            <div class="highlight">3年</div>
                                            <div class="ftc-title">時間</div>
                                        </div>
                                        <div class="ftc-item">
                                            <div class="highlight">90分</div>
                                            <div class="ftc-title">SEO</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute left-0 -bottom-4 w-full flex justify-center items-center">
                                    <button class="btn btn-md btn-ripple btn-success btn-border-0 btn-pill"><i class="fa-solid fa-arrow-right"></i>&nbsp;查看</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">
                                <div class="center-border">
                                    <div class="title">控制項卡片元件</div>
                                    <div class="description"></div>
                                    <div class="control btn-group">
                                        <div
                                            class="btn btn-transition btn-border-0 btn-max btn-text-center btn-md btn-ripple btn-success">
                                            確認
                                        </div>
                                        <div
                                            class="btn btn-transition btn-border-0 btn-max btn-text-center btn-md btn-ripple btn-warning">
                                            取消
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">
                                <div class="relative p-4 group">
                                    <div class="pointer-events-auto h-6 w-10 rounded-full p-1 ring-1 ring-inset transition duration-200 ease-in-out bg-slate-900/10 ring-slate-900/5 group-active:bg-amber-300">
                                        <div class="h-4 w-4 rounded-full bg-white shadow-sm ring-1 ring-slate-700/10 transition duration-200 ease-in-out group-active:translate-x-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">
                                <input type="file" class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-violet-50 file:text-violet-700
                                  hover:file:bg-violet-100
                                "/>
                            </div>
                        </div>
                    </div>
                    <div id="card1" class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="image placeholder lazyImg" data-src="{{asset('assets/images/100x100.svg')}}">
                                <div class="float-text">100x100</div>
                            </div>
                            <div class="content">t</div>
                        </div>
                    </div>
                </div>
                <div class="cards-flex">
                    <div class="card placeholder">
                        <div class="inner">
                            <div class="title"></div>
                            <div class="description"></div>
                        </div>
                    </div>
                    <div class="card placeholder">
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
