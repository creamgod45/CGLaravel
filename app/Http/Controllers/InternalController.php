<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\ELanguageText;
use App\Lib\Type\String\CGStringable;
use App\Lib\Utils\EValidatorType;
use App\Lib\Utils\Utilsv2;
use App\Lib\Utils\ValidatorBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class InternalController extends Controller
{
    /**
     * @param $lang
     * @return void
     */
    private static function setRawCookie($lang): void
    {
        $cookie_expire = time() + (24 * 60 * 60);
        $cookie_path = "/";
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $httponly = true;
        setrawcookie('lang', $lang, ['expires' => $cookie_expire, 'path' => $cookie_path, 'secure' => $secure, 'httponly' => $httponly]);
    }

    public function user(Request $request)
    {
        $filter = $request['filter'];
        Log::info("POST /user payloads:" . new CGStringable($filter));
        $user = $request->user();
        $catcher = [];
        if (empty($user)) return response()->json(["message" => "UNAUTHORIZED"], ResponseHTTP::HTTP_UNAUTHORIZED);
        foreach ($filter as $value) {
            if ($value === "password" || $value === "remember_token") continue;
            $catcher [$value] = $user[$value];
        }
        return $catcher;
    }

    public function browser(Request $request)
    {
        $key = 'guest_id' . self::fingerprint($request);
        if (!Cache::has($key)) {
            Cache::put($key, Str::random(10), 60 * 64 * 24);
        }
        $id = Cache::get($key);
        return response()->json(['id' => $id]);
    }

    public function broadcast_Notification_Notification(Request $request)
    {
        $cgLCI = self::baseControllerInit($request, []);
        $i18N = $cgLCI->getI18N();
        event(new Notification([$request['description'], $request['title'], $request['type'], $request['second']]));
        return response()->json(['message' => $i18N->getLanguage(ELanguageText::DataReceivedSuccessfully), 'raw' => $request['message']]);
    }

    public function language(Request $request)
    {
        $cgLCI = self::baseControllerInit($request, []);
        $i18N = $cgLCI->getI18N();
        $vb = new ValidatorBuilder($i18N, EValidatorType::Language);
        $v = $vb->validate($request->all());
        if($v instanceof MessageBag){
            return response()->json(['message' => 'Error'], ResponseHTTP::HTTP_BAD_REQUEST);
        }else{
            if (empty($request->all())) {
                self::setRawCookie($request['lang']);
                return response()->json(['message' => $i18N->getLanguage(ELanguageText::GetLanguage), 'lang' => $_COOKIE["lang"] ?? ELanguageCode::en_US->name]);
            } elseif (ELanguageCode::isVaild($request['lang'])) {
                self::setRawCookie($request['lang']);
                return response()->json(['message' => $i18N->getLanguage(ELanguageText::DataReceivedSuccessfully), 'lang' => $request['lang']]);
            }
        }
    }

    public function encodeJson(Request $request)
    {
        $cgLCI = self::baseControllerInit($request, []);
        $i18N = $cgLCI->getI18N();
        $decodeContext = Utilsv2::decodeContext($request["a"]);
        return response()->json(['message' => $i18N->getLanguage(ELanguageText::DataReceivedSuccessfully), 'raw' => $decodeContext]);
    }

    public function designComponents(Request $request)
    {
        return view('designcomponents', Controller::baseControllerInit($request)->toArrayable());
    }

    public function branding(Request $request)
    {
        return view('branding', Controller::baseControllerInit($request)->toArrayable());
    }
}
