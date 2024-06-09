<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Lib\I18N\ELanguageCode;
use App\Lib\Type\String\CGStringable;
use App\Lib\Utils\Utilsv2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class InternalController extends Controller
{
    public function user(Request $request)
    {
        $filter = $request['filter'];
        Log::info("POST /user payloads:".new CGStringable($filter));
        $user = $request->user();
        $catcher = [];
        if(empty($user)) return response()->json([
            "message" => "UNAUTHORIZED"
        ], ResponseHTTP::HTTP_UNAUTHORIZED);
        foreach ($filter as $value) {
            if($value === "password" || $value === "remember_token") continue;
            $catcher [$value] = $user[$value];
        }
        return $catcher;
    }

    public function browser(Request $request)
    {
        $key = 'guest_id'.$request->fingerprint();
        if(!Cache::has($key)) {
            Cache::put($key, Str::random(10), 60 * 64 * 24);
        }
        $id = Cache::get($key);
        return response()->json(['id'=>$id]);
    }

    public function broadcast_Notification_Notification(Request $request){
        event(new Notification(
            [$request['description'], $request['title'], $request['type'], $request['second']]
        ));
        return response()->json(['message' => 'Data received successfully', 'raw'=> $request['message']]);
    }

    public function language(Request $request){
        if(empty($request->all())){
            return response()->json(['message' => 'Get Language', 'lang' => $_COOKIE["lang"] ?? ELanguageCode::en_US->name]);
        } elseif (ELanguageCode::isVaild($request['lang'])) {
            $cookie_expire = time() + (24 * 60 * 60);
            $cookie_path = "/";
            $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
            $httponly = true;
            setrawcookie('lang', $request['lang'], [
                'expires' => $cookie_expire,
                'path' => $cookie_path,
                'secure' => $secure,
                'httponly' => $httponly
            ]);
            return response()->json(['message' => 'Data received successfully', 'lang' => $request['lang']]);
        } else {
            return response()->json(['message' => 'Error'], ResponseHTTP::HTTP_BAD_REQUEST);
        }
    }

    public function lzstring_json(Request $request){
        $decodeContext = Utilsv2::decodeContext($request["a"]);
        return response()->json(['message' => 'Data received successfully', 'raw'=> $decodeContext]);
    }

    public function designcomponents (Request $request) {
        return view('designcomponents', Controller::baseControllerInit($request)->toArrayable());
    }

    public function branding(Request $request) {
        return view('branding', Controller::baseControllerInit($request)->toArrayable());
    }
}
