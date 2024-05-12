@vite(['resources/css/branding.css', 'resources/js/branding.js'])
@use (App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\Htmlv2;use App\Lib\Utils\Utilsv2;use Illuminate\Support\Facades\Log)
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
    <!--suppress SpellCheckingInspection -->
    <main class="container1">
        @env('local')
            @php
                debugbar()->info($request->user());
            @endphp
        @endenv
        <div class="p-5">
            <div class="hero-content placeholder lazyImg" data-src="{{asset('assets/images/welcome_banner1.jpg')}}">
                <div id="hero" class="hero-bgdropfilter">
                    <div class="gradable z-[2]">
                        <div class="context">
                            <div class="flex justify-center items-center h-full w-full">
                                <div class="h-fit w-full">
                                    <div class="title noto-serif-tc-bold">正在尋找伺服器承包商或是網站設計?</div>
                                    <div class="subtitle noto-serif-tc-semibold">又或是代管伺服器、活動、資訊安全</div>
                                    <div class="flex justify-center items-center">
                                        <div
                                            class=" btn btn-pill btn-border-0 btn-ripple btn-color1 btn-md btn-text-center">
                                            前往看看
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="_3DModel lazyImg" data-src="{{asset('assets/images/Server3DModel.png')}}"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl md:px-6 footer:px-6 sm:px-2 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-indigo-600">專業級部署</h2>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl noto-serif-tc-bold">
                        所有的應用程式幫你部署並整合</p>
                    <p class="mt-6 text-lg leading-8 text-gray-600"></p>
                </div>
                <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                    <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"/>
                                    </svg>
                                </div>
                                推送及部署
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                使用 Github Action 、Docker、FTP 技術達到，推送及同步部署環境。
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                    </svg>
                                </div>
                                SSL 憑證
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">自動驗證無需擔心，憑證系統自動幫你延期憑證。自動幫你照顧網站。
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                    </svg>
                                </div>
                                簡單佇列服務
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                可以為你的服務提供排程工作的服務，自動執行程式腳本。如清除快取、無用文件、過期會員資料等...
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                         stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33"/>
                                    </svg>
                                </div>
                                高級資訊安全保護
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                DDOS、Tunning、Firewall、SQL injection、CSP、XSS、Log 分析、CSRF、Malware、Phishing、端點保護（Endpoint
                                security）、加密（Encryption）、身份驗證（Authentication）、2FA、安全資訊和事件管理（SIEM）、訪問控制（Access
                                control）、入侵檢測系統/入侵預防系統（IDS/IPS）、漏洞掃描（Vulnerability scanning）
                                、多因素認證（Multi-factor authentication, MFA）、安全開發生命周期（Secure Development
                                Lifecycle, SDL）
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <i class="text-white fa-solid fa-database"></i>
                                </div>
                                資料庫自動化服務
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                優化資料表、建制最佳索引利於程式運算效能優化，自動幫你備份日數據，並且只要動個滑鼠隨時還原或備份。
                            </dd>
                        </div>
                        <div class="relative pl-16">
                            <dt class="text-base font-semibold leading-7 text-gray-900 noto-serif-tc-bold">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                    <i class="text-white fa-solid fa-network-wired"></i>
                                </div>
                                分流系統自動化服務
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                網站過載或是進入高峰載時期，分流系統將給你一臂之力。
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="cloud-service placeholder lazyImg" data-src="{{asset('assets/images/welcome_banner3.jpg')}}">
            <div class="control ct" data-fn="datalist_selector" data-target="#datalist1" data-next="#next1"
                 data-prev="#perv1" data-lists="#datalist1">
                <div id="perv1" class="btn btn-circle btn-ripple btn-ok">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <div id="next1" class="btn btn-circle btn-ripple btn-warning">
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
            </div>
            <div id="datalist1" data-index="0" class="cloud-frame cards-flex1">
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people2.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people2</div>
                                <div class="subtitle">
                                    前端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people1.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people1</div>
                                <div class="subtitle">
                                    後端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people2.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people2</div>
                                <div class="subtitle">
                                    前端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people1.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people1</div>
                                <div class="subtitle">
                                    後端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people2.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people2</div>
                                <div class="subtitle">
                                    前端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people1.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people1</div>
                                <div class="subtitle">
                                    後端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people2.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people2</div>
                                <div class="subtitle">
                                    前端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people1.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people1</div>
                                <div class="subtitle">
                                    後端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people2.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people2</div>
                                <div class="subtitle">
                                    前端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
                <div class="card placeholder rippleable" data-placeholderdelay="2000">
                    <div class="inner">
                        <div class="image-frame">
                            <div class="image-people placeholder placeholder-circle lazyImg"
                                 data-src="{{asset('assets/images/people1.webp')}}"></div>
                        </div>
                        <div class="content">
                            <div class="center-border">
                                <div class="title">people1</div>
                                <div class="subtitle">
                                    後端設計師
                                </div>
                            </div>
                        </div>
                        <div class="btn-bottom-group">
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-envelope"></i>&nbsp;寫信</a>
                            <a class="btn btn-ripple btn-color1 btn-text-center !block"><i
                                    class="fa-solid fa-phone"></i>&nbsp;聯絡</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
