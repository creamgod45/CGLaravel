@php
/***
 * @var string[] $router \
 * @var I18N $i18N
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
        })
    }
</script>
<header class="float-menu">
    <div class="btn-group">
        <a href="/" class="icon lazy-loaded-image" data-src="{{asset("assets/images/logo.webp")}}"></a>
        <a href="/" type="button" class="float-menu-btn" aria-expanded="false">
            <span>{{$i18N->getLanguage(ELanguageText::menu_frontpage)}}</span>
        </a>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float1">
            <span>{{$i18N->getLanguage(ELanguageText::menu_product)}}</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float2">
            <span>{{$i18N->getLanguage(ELanguageText::menu_information)}}</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
    </div>
    <div id="float1" class="float-menu-panel" data-second="450" data-visible="false">
        <div class="float-menu-panel-columns">
            <div class="menu columns-col">
                <div class="item">
                    <div class="title">{{$i18N->getLanguage(ELanguageText::menu_cloudComputing)}}</div>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-cloud"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_googleCloud)}}</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-brands fa-aws"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_aws)}}</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-brands fa-microsoft"></i>
                        <span>&nbsp;{{$i18N->getLanguage(ELanguageText::menu_MicrosoftAzure)}}</span>
                    </a>
                </div>
                <div class="item">
                    <div class="title">網頁設計</div>
                    <a href="" class="menu-btn">
                        <i class="fa-regular fa-newspaper"></i>
                        <span>&nbsp;宣傳頁面</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;形象網頁</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-server"></i>
                        <span>&nbsp;CMS 內容管理平台</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-cash-register"></i>
                        <span>&nbsp;POS 機器整合</span>
                    </a>
                </div>
                <div class="item">
                    <div class="title">客戶案例</div>
                    <a href="https://cgimager.blaetoan.cyou/index.php" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;CGIMAGER</span>
                    </a>
                    <a href="https://cgphp01.blaetoan.cyou/" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;串串幸福</span>
                    </a>
                    <div class="title">廠商操作</div>
                    @guest
                    <a href="/login" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;登入</span>
                    </a>
                    <a href="/register" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;註冊</span>
                    </a>
                    @endguest
                    @auth
                        <a href="/logout" class="menu-btn">
                            <i class="fa-solid fa-shop"></i>
                            <span>&nbsp;登出</span>
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
                    <div class="title">社群媒體</div>
                    <a href="" class="menu-btn"><i class="fa-brands fa-facebook"></i>
                        <span>&nbsp;Facebook</span>
                    </a>
                    <div class="menu-btn"><i class="fa-brands fa-x-twitter"></i><span>&nbsp;X</span></div>
                    <div class="menu-btn"><i class="fa-brands fa-youtube"></i><span>&nbsp;Youtube</span></div>
                    <div class="menu-btn"><i class="fa-brands fa-instagram"></i><span>&nbsp;Instagram</span></div>
                </div>
                <div class="item">
                    <div class="title">資源</div>
                    <div class="menu-btn"><i class="fa-solid fa-users"></i><span>&nbsp;社群</span></div>
                    <div class="menu-btn"><i class="fa-solid fa-globe"></i><span>&nbsp;合作夥伴</span></div>
                    <div class="menu-btn"><i class="fa-solid fa-book-open"></i><span>&nbsp;教學</span></div>
                    <div class="menu-btn"><i class="fa-brands fa-wikipedia-w"></i><span>&nbsp;WIKI</span></div>
                    <div class="menu-btn"><i class="fa-solid fa-shield-halved"></i><span>&nbsp;隱私權</span></div>
                </div>
            </div>
            <div class="columns-col news">
                <div class="item">
                    <div class="image lazy-loaded-image" style="background-position-y: center"
                         data-src="{{asset("assets/images/internationalization.webp")}}">
                    </div>
                    <div class="title">
                        <i class="fa-solid fa-language"></i>&nbsp;語言
                        <div class="tag">全球</div>
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
                    <div class="image lazy-loaded-image" style="background-position-y: center"
                         data-src="{{asset("assets/images/article1.webp")}}">
                    </div>
                    <div class="timestamp">
                        {{Utils::timeStamp(time())}}
                        <div class="tag">永續</div>
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
</header>


