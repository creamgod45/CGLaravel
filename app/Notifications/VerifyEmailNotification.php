<?php

namespace App\Notifications;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use App\Lib\Type\String\CGStringable;
use App\Lib\Utils\RouteNameField;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public I18N $i18N)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        Log::info("=================================================================================================");
        Log::info("Process: VerifyEmailNotification");
        Log::info("Debug \$Instance: " . (new CGStringable($this)));
        Log::info("Debug \$i18N: " . $this->i18N->getLanguageCode()->name);
        Log::info("Debug \$verificationUrl: " . $verificationUrl);
        Log::info("=================================================================================================");
        return (new MailMessage)
            ->subject($this->i18N->getLanguage(ELanguageText::RegisterMailTitle))
            ->line($this->i18N->getLanguage(ELanguageText::RegisterMailLine1))
            ->action($this->i18N->getLanguage(ELanguageText::RegisterMailAction1), $verificationUrl)
            ->line($this->i18N->getLanguage(ELanguageText::RegisterMailLine2));
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            RouteNameField::PageEmailVerification->value,
            now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification())
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [//
        ];
    }
}
