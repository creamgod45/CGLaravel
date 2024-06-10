@php
/***
 * @var string[] $urlParams
 * @var array $moreParams
 * @var I18N $i18N
 * @var Request $request
 * @var string $fingerprint
 */
@endphp
@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Type\Array\CGArray;use App\Lib\Utils\Utils)
<script>
    function changeLanguage(el) {
        let value = el.value;
        let formData = new FormData();
        formData.append('lang', value);
        fetch('language', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"  // Laravel CSRF token
            },
            body: formData,
        }).then(response => {
            if (response.ok) {
                location.reload();
            }
            throw new Error('Network response was not ok.');
        }).catch(response => {
            console.log(response);
        });
    }
</script>
<nav class="float-menu">
    <div class="float-btn-group">
        <a href="/"
           aria-label="首頁連接圖片"
           class="icon placeholder placeholder-circle lazy-loaded-image"
           data-src="{{asset("assets/images/logo.webp")}}"></a>
        <a href="/" type="button" class="float-menu-btn" aria-expanded="false">
            <span><i class="fa-solid fa-house"></i>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_frontpage)}}</span>
        </a>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float1">
            <span>{{$i18N->getLanguage(ELanguageText::menu_product)}}</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float2">
            <span>{{$i18N->getLanguage(ELanguageText::menu_information)}}</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
        @env('local')
            <a href="{{route('designcomponents')}}" class="float-menu-btn" aria-expanded="false">
                <span>元件測試頁面</span>
            </a>
        @endenv
    </div>
    <div id="float1" class="float-menu-panel" data-second="450" data-visible="false">
        <div class="float-menu-panel-columns">
            <div class="menu columns-col">
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_cloudComputing)}}</div>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-cloud"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_googleCloud)}}</span>
                    </a>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-brands fa-aws"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_aws)}}</span>
                    </a>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-brands fa-microsoft"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_MicrosoftAzure)}}</span>
                    </a>
                </div>
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_WebDesign)}}</div>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-regular fa-newspaper"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_PromotionalPage)}}</span>
                    </a>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_BrandingWebsite)}}</span>
                    </a>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-server"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_CMS)}}</span>
                    </a>
                    <a href="" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-cash-register"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_POS)}}</span>
                    </a>
                </div>
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_ClientCaseStudies)}}</div>
                    <a href="https://cgimager.blaetoan.cyou/index.php" target="_blank" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;CGIMAGER <i class="fa-solid fa-square-arrow-up-right"></i></span>
                    </a>
                    <a href="https://cgphp01.blaetoan.cyou/" target="_blank" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;串串幸福 <i class="fa-solid fa-square-arrow-up-right"></i></span>
                    </a>
                    <a href="https://creamgod45.github.io/TimeCalculate/" target="_blank" class="menu-btn btn-ripple">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;時間計算程式 <i class="fa-solid fa-square-arrow-up-right"></i></span>
                    </a>
                </div>
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_VendorOperations)}}</div>
                    @guest
                        <a href="{{route('member.form-login')}}" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-shop"></i>
                            <span>&nbsp;{{$i18N->getLanguage(ELanguageText::login_title)}}</span>
                        </a>
                        <a href="/register" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-shop"></i>
                            <span>&nbsp;{{$i18N->getLanguage(ELanguageText::register_title)}}</span>
                        </a>
                    @endguest
                    @auth
                        @php
                            $user = Auth::user();
                        @endphp
                        @if(!$user->hasVerifiedEmail())
                        <a href="/resendemail" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>&nbsp;重新驗證</span>
                        </a>
                        @endif
                        <a href="{{route('member.profile')}}" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-user"></i>
                            <span>&nbsp;個人資料</span>
                        </a>
                        <a href="/members" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-shop"></i>
                            <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_membersBtn)}}</span>
                        </a>
                        <a href="/logout" class="menu-btn btn-ripple">
                            <i class="fa-solid fa-shop"></i>
                            <span>&nbsp;{{$i18N->getLanguage(ELanguageText::logout_title)}}</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div id="float2" class="float-menu-panel" data-second="450" data-visible="false">
        <div class="float-menu-panel-columns">
            <div class="menu columns-col">
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_SocialMedia)}}</div>
                    <a href="" class="menu-btn btn-ripple"><i class="fa-brands fa-facebook"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_facebook)}}</span>
                    </a>
                    <div class="menu-btn btn-ripple"><i class="fa-brands fa-x-twitter"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_X)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-brands fa-youtube"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_Youtube)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-brands fa-instagram"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_Instagram)}}</span></div>
                </div>
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_resource)}}</div>
                    <div class="menu-btn btn-ripple"><i class="fa-solid fa-users"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_community)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-solid fa-globe"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_Partner)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-solid fa-book-open"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_guide)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-brands fa-wikipedia-w"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_WIKI)}}</span></div>
                    <div class="menu-btn btn-ripple"><i class="fa-solid fa-shield-halved"></i><span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_Privacy)}}</span></div>
                </div>
            </div>
            <div class="columns-col news">
                <div class="item">
                    <div class="image placeholder lazy-loaded-image" style="background-position-y: center"
                         data-src="{{asset("assets/images/internationalization.webp")}}">
                    </div>
                    <div class="title">
                        <i class="fa-solid fa-language"></i>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_language)}}
                        <div class="tag btn-ripple">{{$i18N->getLanguage(ELanguageText::menu_tag_global)}}</div>
                    </div>
                    <select aria-label="language select bar" onchange="changeLanguage(this);">
                        <option selected
                                value="{{ $i18N->getLanguageCode()->name }}">{{ $i18N->getLanguage(ELanguageText::valueof($i18N->getLanguageCode()->name)) }}</option>
                        @php
                            $list = $i18N->getELanguageCodeList();
                            foreach ($list as $key=> $item){
                                if($item === $i18N->getLanguageCode()) {
                                    array_splice($list, $key, 1);
                                    break;
                                }
                            }
                        @endphp
                        @foreach($list as $lang)
                            <option value="{{$lang->name}}">
                                {{$i18N->getLanguage(ELanguageText::valueof($lang->name))}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="item">
                    <div class="image placeholder lazy-loaded-image" style="background-position-y: center"
                         data-src="{{asset("assets/images/article1.webp")}}">
                    </div>
                    <div class="timestamp">
                        {{Utils::timeStamp(time())}}
                        <div class="tag btn-ripple">{{$i18N->getLanguage(ELanguageText::menu_tag_Sustainable)}}</div>
                    </div>
                    <div class="title">
                        勵志推廣舒適的環保環境
                    </div>
                    <div class="article">
                        辦公室一個溫馨且環保的辦公空間。大片的窗戶展望著外面被雪覆蓋的森林，這不僅提供了自然的光線，也降低了室內照明的需求，這是節能的一個方面。室內的桌子和書架似乎是用天然木材製成的，這顯示了使用可持續材料的選擇。桌面上和書架上的裝飾和容器可能是手工製作或使用環保材料，這進一步強調了對自然資源的尊重。整體而言，這個辦公空間的設計體現了對環境的考慮和可持續性的價值。
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>


