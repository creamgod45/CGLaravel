<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\Utils;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

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

        $i18n = new I18N(Utils::default(ELanguageCode::valueof($pathParts[1]), ELanguageCode::en_US), limitMode: [ELanguageCode::zh_TW, ELanguageCode::zh_CN, ELanguageCode::en_US, ELanguageCode::en_GB]);
        return ['router' => $router, 'i18N' => $i18n, ...$params];
    }
}
