<?php

namespace App\Http\Middleware;

use App\Lib\Utils\RouteNameField;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        if ($request->is('hello')) {
            return $next($request);
        }

        if (!$request->session()->has('ClientID')) {
            return redirect()->route(RouteNameField::PageGetClientID->value); // 替换为你的路由名称
        }

        return $next($request);
    }
}
