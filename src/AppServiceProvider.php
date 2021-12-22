<?php

namespace XRequestID;

use Illuminate\Http\Request;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $xRequestID = $_SERVER['HTTP_X_REQUEST_ID'] ?? Str::random(32);
        $this->app->singleton(Conf::APP_ID, function ($app) use ($xRequestID) {
            return $xRequestID;
        });
    }

    public function boot()
    {
        $startID = $this->app[Conf::APP_ID];
        $this->app['events']->listen(JobProcessing::class, function ($event) use($startID) {
            $this->app->extend('x-request-id', function ($service) use ($event, $startID) {
                /** @var Job $job */
                $job = $event->job;
                return $startID . '_' . $job->getJobId();
            });
        });
    }
}
