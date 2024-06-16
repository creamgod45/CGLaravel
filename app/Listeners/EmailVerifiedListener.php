<?php

namespace App\Listeners;

use App\Models\Member;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EmailVerifiedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        //
        $user = $event->user;
        if($user instanceof Member) {
            Log::info('User verified', ['user_id' => $user->id, 'email' => $user->email]);
            event(new WelcomeEmailNotification($i18N, $data));
        }
    }
}
