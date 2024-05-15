<?php

namespace App\View\Components;

use App\Lib\Utils\Utils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notificationitem extends Component
{
    public string $title;
    public string $description;
    public string $type;
    public int $line;
    public function __construct($line, $title, $description, $type)
    {
        $this->line=Utils::default($line, 0);
        $this->title=Utils::default($title, "");
        $this->description=Utils::default($description, "");
        $this->type=Utils::default($description, "info");
    }

    public function render(): View|Closure|string
    {
        return view('components.notificationitem');
    }
}
