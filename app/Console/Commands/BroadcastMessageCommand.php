<?php

namespace App\Console\Commands;

use App\Jobs\BroadcastMessageJob;
use Illuminate\Console\Command;

class BroadcastMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:broadcast-message-command';

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
        dispatch(new BroadcastMessageJob());
    }
}
