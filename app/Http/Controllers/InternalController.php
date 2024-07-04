<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\ELanguageText;
use App\Lib\Type\String\CGStringable;
use App\Lib\Utils\ClientConfig;
use App\Lib\Utils\EncryptedCache;
use App\Lib\Utils\EValidatorType;
use App\Lib\Utils\Utilsv2;
use App\Lib\Utils\ValidatorBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
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

    public function getClientID(Request $request)
    {
        return view('getClientID', Controller::baseControllerInit($request)->toArrayable());
    }

    public function getClientIDPost(Request $request)
    {
        $cgLCI = self::baseControllerInit($request, []);
        $i18N = $cgLCI->getI18N();

        $vb = new ValidatorBuilder($i18N, EValidatorType::GETCLIENTID);
        $v = $vb->validate($request->all(), ['ID'], true);
        if ($v instanceof MessageBag && !Session::has("ClientID")) {
            return response()->json(['message' => 'failed']);
        } else {
            if (!Session::has('ClientID')) {
                Session::put("ClientID", sha1($v['ID']));
                EncryptedCache::put(Session::get("ClientID") . "_ClientConfig", new ClientConfig(ELanguageCode::en_US->name), now()->addDays(1));
            }
            return response()->json(['message' => 'ok']);
        }
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
        $key = self::fingerprint($request->session()->get('ClientID'));
        return response()->json(['id' => $key]);
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
        if ($v instanceof MessageBag) {
            return response()->json(['message' => 'Error'], ResponseHTTP::HTTP_BAD_REQUEST);
        } else {
            $config = EncryptedCache::get(Session::get("ClientID") . "_ClientConfig");
            if ($config instanceof ClientConfig) {
                $language = $config->getLanguage();
                if (empty($request->all())) {
                    return response()->json(['message' => $i18N->getLanguage(ELanguageText::GetLanguage), 'lang' => $language]);
                } elseif (ELanguageCode::isVaild($request['lang'])) {
                    $config->setLanguage($request['lang']);
                    $config->setLanguageClass(ELanguageCode::valueof($request['lang']));
                    EncryptedCache::put(Session::get("ClientID") . "_ClientConfig", $config, now()->addDays());
                    return response()->json(['message' => $i18N->getLanguage(ELanguageText::DataReceivedSuccessfully), 'lang' => $language]);
                }
            }
            return response()->json(['message' => 'Error1'], ResponseHTTP::HTTP_BAD_REQUEST);
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
