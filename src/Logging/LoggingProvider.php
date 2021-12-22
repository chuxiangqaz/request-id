<?php

namespace XRequestID;

use Illuminate\Http\Request;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LoggingProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->extend('log', function ($service) {
            return new Log($service, $this->app);
        });
    }
}
