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
            <div class="outline-btn-demo">
                這是關於 Outline Button(Filter) 示範
                <form method="post" onsubmit="return false;">
                    <div class="form-peer">
                        <input id="email" class="peer hidden" type="checkbox" name="email">
                        <label for="email" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">驗證信件</label>
                    </div>
                    <div class="form-peer">
                        <input id="phone1" class="peer hidden" type="radio" name="filter-phone">
                        <label for="phone1" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">電話(A~Z)
                        </label>
                    </div>
                    <div class="form-peer">
                        <input id="phone2" class="peer hidden" type="radio" name="filter-phone">
                        <label for="phone2" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">電話(Z~A)</label>
                    </div>
                </form>
            </div>
            <div class="floatUI-demo">
                <button id="A" class="btn btn-color1 btn-ripple relative !z-[1]" data-for="b">
                    FloatUI Test
                </button>
                <div id="B" class="absolute !invisible !z-[2] w-fit text-black bg-slate-200">
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                    testasssssssssssssssssssssssssssssssss<br>
                </div>
            </div>
            <div class="tooltip-demo">
                <div class="placeholder" data-placeholderdelay="10000">
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
                <a class="btn btn-md btn-dead btn-border-0">1</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0">2</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0">3</a>
                <a class="btn btn-ripple btn-md btn-color1 btn-border-0"><i class="fa-solid fa-right-long"></i></a>
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
                            <div class="content">
                                <div class="center-border">
                                    <div class="title">控制項卡片元件</div>
                                    <div class="description">
                                        這是一個問題卡片
                                    </div>
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
            <div class="breadcrumb-demo">
                這是 breadcrumb 示範
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" class="bcitem">
                        <i class="fa-solid fa-house"></i>&nbsp;Home
                    </a>
                    <a class="bcitem">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                    <div class="bcitem">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>&nbsp;安裝精靈
                    </div>
                    <div class="bcitem">
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                    <div class="bcitem active">
                        <i class="fa-solid fa-download"></i>&nbsp;安裝
                    </div>
                </div>
            </div>
            <div class="form-demo">
                這是 Form 示範
                <p>Solid</p>
                <div class="form-group">
                    <label for="text1">文字</label>
                    <input id="text1" class="block form-solid" type="text" required>
                </div>
                <div class="form-group">
                    <label for="text2">文字(僅讀取)</label>
                    <input id="text2" class="block form-solid" value="test" type="text" readonly>
                </div>
                <div class="form-group">
                    <label for="text42">文字(關閉)</label>
                    <input id="text42" class="block form-solid" value="test" type="text" disabled>
                </div>
                <div class="form-row-nowarp">
                    <label for="text3" class="col-1 flex justify-start items-center">文字</label>
                    <input id="text3" class="block form-solid col-11" type="text" required>
                </div>
                <form class="form-group" method="post" onsubmit="return false;">
                    <div class="form-group">
                        <label for="text4">密碼</label>
                        <div class="form-password-group">
                            <input id="text4" class="block form-solid front" type="password" autocomplete="new-password" required>
                            <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle" data-target="#text4"><i class="fa-regular fa-eye"></i></div>
                        </div>
                    </div>
                    <div class="form-group-flex">
                        <label for="file2" class="btn btn-dead btn-md min-w-fit btn-border-0">選擇檔案</label>
                        <input id="file2" type="file" disabled multiple class="block w-full form-file btn-ripple"/>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-solid" required>
                    </div>
                    <div class="form-group">
                        <input type="datetime-local" class="form-solid" required>
                    </div>
                    <div class="form-group">
                        <input type="time" class="form-solid" required>
                    </div>
                    <div class="form-group">
                        <input type="color" class="form-color btn btn-cancel btn-border-0" disabled>
                    </div>
                    <div class="form-group">
                        <input type="month" class="form-solid" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-solid" required>
                    </div>
                    <div class="form-group">
                        <input type="range" min="0" max="9" class="form-range" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-solid ITI" autocomplete="phone" data-btn="#phone-Validator-btn" data-msg="#phone-Validator-msg" data-true="ok" data-false="failed" required>
                        <button id="phone-Validator-btn" class="btn btn-ripple btn-md btn-color1" type="button">驗證</button>
                        <span id="phone-Validator-msg" class="hidden"></span>
                    </div>

                    <div class="form-group-flex">
                        <label for="file1" class="btn btn-ripple btn-md btn-ripple btn-color1 min-w-fit btn-border-0">選擇檔案</label>
                        <input id="file1" type="file" multiple class="block w-full form-file btn-ripple"/>
                    </div>
                    <div class="form-peer">
                        <input id="email2" class="peer hidden" type="checkbox" name="email">
                        <label for="email2" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">驗證信件 checkbox</label>
                    </div>
                    <div class="form-peer">
                        <input id="phone3" class="peer hidden" type="radio" name="filter-phone">
                        <label for="phone3" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">電話(A~Z) radio
                        </label>
                    </div>
                    <div class="form-peer">
                        <input id="phone4" class="peer hidden" type="radio" name="filter-phone">
                        <label for="phone4" class="peer-checked:bg-blue-500 peer-checked:text-white outline-btn">電話(Z~A) radio</label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning btn-ripple btn-center btn-md-strip">送出</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection
