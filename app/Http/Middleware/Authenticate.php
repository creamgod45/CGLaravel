<?php

namespace App\Http\Middleware;

use App\Events\UserNotification;
use App\Http\Controllers\Controller;
use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Type\String\CGStringable;
use App\Lib\Utils\ClassUtils;
use App\Lib\Utils\RouteNameField;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route(RouteNameField::PageLogin->value);
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check() && Auth::user()->enable === "false") {
            //Log::info("Authenticate Middleware 1");
            $locale = App::getLocale();
            //dump($locale);
            $ELanguageCode = ELanguageCode::valueof($locale);
            if ($ELanguageCode === null) $ELanguageCode = ELanguageCode::en_US;
            $i18N = new I18N($ELanguageCode, limitMode: [
                ELanguageCode::zh_TW,
                ELanguageCode::zh_CN,
                ELanguageCode::en_US,
                ELanguageCode::en_GB
            ]);
            try {
                Log::info("Middleware Authenticate dump variables" . Json::encode([$ELanguageCode === null, $ELanguageCode instanceof ELanguageCode ? $ELanguageCode->name : $ELanguageCode, $locale, serialize($i18N), $i18N->getLanguage(ELanguageText::ResetPasswordLine1)], true));
            } catch (JsonException $e) {
                Log::error("backtrace: " . $e->getMessage() . (new CGStringable(ClassUtils::varName($e))));
            }
            event((new UserNotification([
                "你的帳號因已經停用，所以你已被強制登出。",
                "警告訊息",
                "warning",
                10000,
                Cache::get('guest_id' . Controller::fingerprintStaticable($request))
            ]))->delay(now()->addSeconds(5)));
            Auth::logout();
            //Log::info("Authenticate Middleware 2");
            return redirect(route(RouteNameField::PageLogin->value));
        }
        //Log::info("Authenticate Middleware 3");

        return parent::handle($request, $next, ...$guards);
    }
}
