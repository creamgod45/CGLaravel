<?php
/***
 * @var string[] $router \
 * @var I18N $i18N
 */
?>
@use(App\Lib\I18N\ELanguageText;use App\Lib\I18N\I18N;use App\Lib\Utils\Utils)

<script>
    function changeLanguage(el) {
        let value = el.value;
        console.log(location);
        location.assign("<?= Utils::getInstanceAddress(true) ?>/<?= Utils::default($router[1], \App\Lib\I18N\ELanguageCode::en_US->name) ?>/" + value);
    }
</script>
<header class="float-menu">
    <div class="btn-group">
        <div class="icon lazy-loaded-image" data-src="<?= Utils::resources("images/logo.webp") ?>"></div>
        <button type="button" class="float-menu-btn" aria-expanded="false">
            <span>首頁</span>
        </button>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float1">
            <span>產品</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
        <button type="button" class="float-menu-btn" aria-expanded="false" data-target="#float2">
            <span>資訊</span>
            <i class="fa-solid fa-caret-down"></i>
        </button>
    </div>
    <div id="float1" class="float-menu-panel" data-second="450" data-visible="false">
        <div class="float-menu-panel-columns">
            <div class="menu columns-col">
                <div class="item">
                    <div class="title">雲端計算</div>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-cloud"></i>
                        <span>&nbsp;Google Cloud</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-brands fa-aws"></i>
                        <span>&nbsp;AWS</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-brands fa-microsoft"></i>
                        <span>&nbsp;Microsoft Azure</span>
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
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;CGIMAGER</span>
                    </a>
                    <a href="" class="menu-btn">
                        <i class="fa-solid fa-shop"></i>
                        <span>&nbsp;串串幸福</span>
                    </a>
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
                         data-src="<?= Utils::resources("images/internationalization.webp") ?>">
                    </div>
                    <div class="title">
                        <i class="fa-solid fa-language"></i>&nbsp;語言
                        <div class="tag">全球</div>
                    </div>
                    <select aria-label="language select bar" onchange="changeLanguage(this);">
                        <option selected
                                value="<?= $i18N->getLanguageCode()->name ?>"><?= $i18N->getLanguage(ELanguageText::valueof($i18N->getLanguageCode()->name)) ?></option>
                    </select>
                </div>
                <div class="item">
                    <div class="image lazy-loaded-image" style="background-position-y: center"
                         data-src="<?= Utils::resources("images/article1.webp") ?>">
                    </div>
                    <div class="timestamp">
                        <?= Utils::timeStamp(time()) ?>
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


