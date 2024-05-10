@use(App\Lib\I18N\ELanguageText)
<footer>
    <div class="f1">
        <div class="footer-menu">
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
        </div>
        <div class="footer1">
            <div class="row">
                <div class="col">© {{date("Y")}} CGCenter Author:&nbsp;<a target="_blank" href="https://github.com/creamgod45">CreamGod45</a></div>
                <div  class="col">Power by&nbsp;<a class="laravel" href="https://laravel.com/" target="_blank">Laravel 10</a>.</div>
            </div>
        </div>
    </div>
</footer>
