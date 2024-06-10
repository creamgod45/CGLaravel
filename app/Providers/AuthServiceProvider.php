<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Lib\I18N\ELanguageCode;
use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Utils\RouteNameField;
use App\Models\Member;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        ResetPassword::toMailUsing(function (Member $member, $token)  {
            $locale = App::getLocale();
            //dump($locale);
            $ELanguageCode = ELanguageCode::valueof($locale);
            if($ELanguageCode === null) $ELanguageCode=ELanguageCode::en_US;
            $i18N = new I18N($ELanguageCode, limitMode: [
                ELanguageCode::zh_TW,
                ELanguageCode::zh_CN,
                ELanguageCode::en_US,
                ELanguageCode::en_GB
            ]);
            $vars=dump([$ELanguageCode===null,$ELanguageCode instanceof ELanguageCode ? $ELanguageCode->name : $ELanguageCode, $locale, serialize($i18N), $i18N->getLanguage(ELanguageText::ResetPasswordLine1)]);
            Log::info("ResetPassword dump variables".Json::encode($vars, true));
            return (new MailMessage)
                ->line($i18N->getLanguage(ELanguageText::ResetPasswordLine1))
                ->action($i18N->getLanguage(ELanguageText::ResetPasswordAction1), url(route(RouteNameField::PagePasswordReset->value, ['token'=>$token, 'email' => $member->email], false)))
                ->line($i18N->getLanguage(ELanguageText::ResetPasswordLine2));
        });
    }
}
