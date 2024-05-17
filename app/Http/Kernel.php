<?php

namespace App\Http;

use App\Http\Middleware\EMiddleWareAliases;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\SetLocale::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        EMiddleWareAliases::auth->name => \App\Http\Middleware\Authenticate::class,
        EMiddleWareAliases::auth_basic->name => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        EMiddleWareAliases::auth_session->name => \Illuminate\Session\Middleware\AuthenticateSession::class,
        EMiddleWareAliases::cache_headers->name=>\Illuminate\Http\Middleware\SetCacheHeaders::class,
        EMiddleWareAliases::can->name=> \Illuminate\Auth\Middleware\Authorize::class,
        EMiddleWareAliases::guest->name=> \App\Http\Middleware\RedirectIfAuthenticated::class,
        EMiddleWareAliases::password_confirm->name=> \Illuminate\Auth\Middleware\RequirePassword::class,
        EMiddleWareAliases::precognitive->name=> \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
        EMiddleWareAliases::signed->name=> \App\Http\Middleware\ValidateSignature::class,
        EMiddleWareAliases::throttle->name=> \Illuminate\Routing\Middleware\ThrottleRequests::class,
        EMiddleWareAliases::verified->name=> \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
