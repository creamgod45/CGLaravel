<?php

namespace App\View\Components;

use App\Lib\Utils\ENotificationType;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class NotificationItem extends Component
{
    /**
     * Create a new component instance.
     * @param string $title
     * @param string $description
     * @param string $id
     * @param string $type
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $id = "",
        public ENotificationType $type = ENotificationType::info,
    )
    {
        $this->id="N".Str::random(7);
        //
    }

    public function render(): View
    {
        return view('Components.notification-item');
    }
}
