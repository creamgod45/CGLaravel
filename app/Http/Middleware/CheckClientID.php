<?php

namespace App\Http\Middleware;

use Closure;
use App\Lib\Utils\RouteNameField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CheckClientID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('ClientID') && !Config::get('app.env') === "testing") {
            return redirect()->route(RouteNameField::PageGetClientID->value); // 替换为你的路由名称
        }
        if(Config::get('app.env') === "testing"){
            $request->session()->put('ClientID', sha1(time()));
        }

        return $next($request);
    }
}
