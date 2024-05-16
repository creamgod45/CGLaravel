<?php

namespace App\Http\Middleware;

use App\Lib\I18N\ELanguageCode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('lang')) {
            $locale = Cookie::get('lang', ELanguageCode::en_US->name);
            App::setLocale($locale);
        }
        return $next($request);
    }
}
