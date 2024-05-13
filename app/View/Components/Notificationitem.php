<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class notificationitem extends Component
{
    public string $title="";
    public string $description="";
    public string $type = "info";
    public function __construct(
        $title,
        $description,
        $type,
    )
    {

    }

    public function render(): View|Closure|string
    {
        return view('components.notificationitem');
    }
}
