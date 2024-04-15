<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\Utils;
use http\Cookie;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
     * @param Request $request
     * @param array $params
     * @return array
     */
    public function baseGlobalVariable(Request $request, array $params = []): array
    {
        $url = $request->url();
        $path = parse_url($url, PHP_URL_PATH);
        $pathParts = explode('/', $path);
        $router = array_filter($pathParts);
        $lang = $request->cookie('lang', ELanguageCode::en_US->name);
        //debugbar()->info($lang);
        $i18N = new I18N(ELanguageCode::valueof($lang), limitMode: [ELanguageCode::zh_TW, ELanguageCode::zh_CN, ELanguageCode::en_US, ELanguageCode::en_GB]);
        //debugbar()->info($i18N->getLanguageCode()->name);
        $i18N->setLanguageCode($i18N->getLanguageCode());
        return ['router' => $router, 'i18N' => $i18N, ...$params];
    }
}
