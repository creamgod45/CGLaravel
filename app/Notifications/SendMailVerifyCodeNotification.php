<?php

namespace App\Notifications;

use App\Lib\I18N\ELanguageText;
use App\Lib\I18N\I18N;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMailVerifyCodeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public I18N $i18N, public string $code)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->i18N->getLanguage(ELanguageText::sendMailVerifyCode_Response_error1))
            ->line($this->i18N->getLanguage(ELanguageText::sendMailVerifyCodeLine1, true)->placeholderParser("code", $this->code)->toString())
            ->line($this->i18N->getLanguage(ELanguageText::sendMailVerifyCodeLine2));
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
