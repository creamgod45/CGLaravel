<?php

namespace App\Http\Middleware;

use App\Lib\I18N\ELanguageCode;
use App\Lib\Utils\EncryptedCache;
use App\Lib\Utils\RouteNameField;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CheckClientID
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Config::get('app.env') === "testing") {
            $request->session()->put('ClientID', sha1(time()));
            EncryptedCache::put($request->session()->get("ClientID") . "_ClientConfig", [
                "language" => ELanguageCode::en_US->name
            ], now()->addDays(1));
        }
        if (!$request->session()->has('ClientID')) {
            return redirect()->route(RouteNameField::PageGetClientID->value); // 替换为你的路由名称
        }

        return $next($request);
    }
}
