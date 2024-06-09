<?php

namespace App\Http\Controllers;

use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\I18N;
use App\Lib\Utils\CGLaravelControllerInit;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public static function baseControllerInit(Request $request, array ...$params): CGLaravelControllerInit
    {
        return (new Controller)->extracted($request, $params);
    }

    /**
     * @param Request $request
     * @param array $params
     * @return array
     */
    public function baseGlobalVariable(Request $request, array $params = []): CGLaravelControllerInit
    {
        return $this->extracted($request, $params);
    }

    /**
     * @param Request $request
     * @param array $params
     * @return array
     */
    public function extracted(Request $request, array $params): CGLaravelControllerInit
    {
        $url = $request->url();
        $path = parse_url($url, PHP_URL_PATH);
        $router=[];
        if($path!==null){
            $pathParts = explode('/', $path);
            $router = array_filter($pathParts);
        }
        $lang = App::getLocale();
        if(isset($_COOKIE['lang'])){
            $lang=$_COOKIE['lang'];
            //dump(1);
        }
        //dump($lang);
        //debugbar()->info($lang);
        $i18N = new I18N(ELanguageCode::valueof($lang), limitMode: [ELanguageCode::zh_TW, ELanguageCode::zh_CN, ELanguageCode::en_US, ELanguageCode::en_GB]);
        $fingerprint = $this->fingerprint($request);
        return new CGLaravelControllerInit($i18N, $router, $request, $params, $fingerprint);
    }

    public function fingerprint(Request $request){
        return sha1($request->ip().$request->getHost().$request->userAgent());
    }
}
