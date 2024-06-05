<?php

namespace App\Console\Commands;

use App\Events\Notification;
use App\Jobs\BroadcastMessageJob;
use Illuminate\Console\Command;
use Psy\Util\Json;

class BroadcastMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'broadcast:Notification {message} {title} {type} {second}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        event(new Notification([$this->argument('message'), $this->argument('title'), $this->argument('type'), $this->argument('second')]));
    }
}
