@vite(['resources/css/profile.css', 'resources/js/profile.js'])
@use (App\Lib\I18N\I18N)
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
@section('title', "個人資料")
@section('content')
    <!--suppress SpellCheckingInspection -->
    <main class="container1">
        @env('local')
        @endenv
        <div class="p-5">
            <div class="section">
                <div class="profile-grid-list">
                    @php
                        $member=\Illuminate\Support\Facades\Auth::user();
                    @endphp
                    <div class="item">
                        <div class="col fixed1">ID</div>
                        <div class="col">{{$member->id}}</div>
                    </div>
                    <div class="item">
                        <div class="col fixed1">帳號</div>
                        <div class="col">{{$member->username}}</div>
                    </div>
                    <div class="item">
                        <div class="col fixed1">電子郵件</div>
                        <div class="col">{{$member->email}}
                            @php
                                $emailpopover = new \App\View\Components\PopoverOptions();
                            @endphp
                            <x-popover
                                btn-class-list="btn btn-color1 btn-ripple"
                                popover-btn-message="編輯"
                                :popover-options="$emailpopover"
                                class="!min-w-[320px] xxl:!w-8/12"
                                popover-title="編輯電子信箱">
                                <form action="" method="POST">
                                    <button type="button"
                                            class="btn btn-ripple btn-color1 btn-max btn-center ct"
                                            data-fn="sendMailVerifyCode"
                                            data-target="#sendMailVerifyCodeResult"
                                    >發送驗證碼【驗證身份】</button>
                                    <p id="sendMailVerifyCodeResult">已經寄送驗證碼至信箱，請先驗證信箱</p>
                                    @csrf
                                    <div class="form-row-nowarp sm:!flex-wrap xs:!flex-wrap us:!flex-wrap">
                                        <label for="MailCatcher" class="xxl:w-1/12 xl:w-2/12 lg:w-2/12 md:w-2/12 footer:w-3/12 sm:w-full xs:w-full us:w-full flex justify-start items-center">驗證身份</label>
                                        <input id="MailCatcher" class="block form-solid xxl:w-9/12 xl:w-8/12 lg:w-8/12 md:w-8/12 footer:w-6/12 sm:w-full xs:w-full us:w-full" type="text" autocomplete="current-email" required>
                                        <div class="footer:px-5 xxl:w-2/12 xl:w-2/12 lg:w-2/12 md:w-2/12 footer:w-3/12 sm:w-full footer:mt-0 xs:w-full sm:mt-5 xs:mt-5 us:w-full us:mt-5 sm:px-0">
                                            <button class="btn btn-max btn-center btn-color1 btn-ripple">驗證</button>
                                        </div>
                                    </div>
                                    <div class="form-row-nowarp sm:!flex-wrap xs:!flex-wrap us:!flex-wrap mt-5">
                                        <label for="email" class="xxl:w-1/12 xl:w-2/12 lg:w-2/12 md:w-2/12 footer:w-3/12 sm:w-full xs:w-full us:w-full flex justify-start items-center">電子信箱</label>
                                        <input id="email" class="block form-solid xxl:w-9/12 xl:w-8/12 lg:w-8/12 md:w-8/12 footer:w-6/12 sm:w-full xs:w-full us:w-full" type="email" name="email" autocomplete="email" disabled required>
                                        <div class="footer:px-5 xxl:w-2/12 xl:w-2/12 lg:w-2/12 md:w-2/12 footer:w-3/12 sm:w-full footer:mt-0 xs:w-full sm:mt-5 xs:mt-5 us:w-full us:mt-5 sm:px-0">
                                            <button class="btn btn-max btn-center btn-color1 btn-ripple">發送</button>
                                        </div>
                                    </div>
                                    <div class="form-row-nowarp mt-5 xs:!flex-wrap sm:!flex-wrap us:!flex-wrap">
                                        <label for="verification" class="xxl:w-1/12 xl:w-2/12 lg:w-2/12 md:w-2/12 footer:w-3/12 sm:w-full xs:w-full us:w-full flex justify-start items-center">驗證碼</label>
                                        <input id="verification" class="block form-solid xxl:w-11/12 xl:w-10/12 lg:w-10/12 md:w-10/12 footer:w-9/12 sm:w-full xs:w-full us:w-full" type="text" name="verification" autocomplete="off" disabled required>
                                    </div>
                                    <button type="submit" class="mt-5 btn btn-ripple btn-max btn-color1 btn-center">更改電子信箱</button>
                                </form>
                            </x-popover>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col fixed1 value">密碼</div>
                        <div class="col">*****************
                            @php
                                $passwordpopover = new \App\View\Components\PopoverOptions();
                            @endphp
                            <x-popover
                                btn-class-list="btn btn-color1 btn-ripple"
                                popover-btn-message="編輯"
                                :popover-options="$passwordpopover"
                                class="xxl:!w-7/12"
                                popover-title="編輯密碼">
                                <form action="" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="password1">現在密碼</label>
                                        <div class="form-password-group">
                                            <input id="password1" class="block form-solid front" type="password" autocomplete="current-password"
                                                   required>
                                            <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                                                 data-target="#password1"><i class="fa-regular fa-eye"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password2">新密碼</label>
                                        <div class="form-password-group">
                                            <input id="password2" class="block form-solid front" type="password" name="password" autocomplete="new-password"
                                                   required>
                                            <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                                                 data-target="#password2"><i class="fa-regular fa-eye"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password3">重複密碼</label>
                                        <div class="form-password-group">
                                            <input id="password3" class="block form-solid front" type="password" name="password_confirmation" autocomplete="new-password"
                                                   required>
                                            <div class="btn btn-ripple btn-color1 btn-border-0 back ct" data-fn="password-toggle"
                                                 data-target="#password3"><i class="fa-regular fa-eye"></i></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="mt-5 btn btn-ripple btn-color1 btn-md-strip">更改密碼</button>
                                </form>
                            </x-popover>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col fixed1">電子郵件驗證時間</div>
                        <div class="col">{{$member->email_verified_at}}</div>
                    </div>
                    <div class="item">
                        <div class="col fixed1">電話</div>
                        <div class="col">{{$member->phone}}</div>
                    </div>
                    <div class="item">
                        <div class="col fixed1 value">可使用會員</div>
                        <div class="col">
                            <x-boolean-string-cover :value="$member->enable" :i18-n="$i18N"/>
                        </div>
                    </div>
                    <div class="item">
                        <div class="col fixed1 value">管理員</div>
                        <div class="col">
                            <x-boolean-string-cover :value="$member->administrator" :i18-n="$i18N"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
