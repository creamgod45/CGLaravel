<?php

namespace App\Providers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->exception
            Log::warning("Queue::failing(JobFailed): ", [
                $event->job->getJobId(),
                $event->job->getQueue(),
                $event->job->getRawBody(),
                $event->job->getConnectionName(),
                $event->job->getName(),
                $event->connectionName,
                $event->exception->getMessage(),
            ]);
        });
    }
}
