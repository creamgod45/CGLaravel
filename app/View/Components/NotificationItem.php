<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class NotificationItem extends Component
{
    public function __construct(
        public string $title,
        public string $description,
        public string $id = "",
        public string $type = "info",
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
