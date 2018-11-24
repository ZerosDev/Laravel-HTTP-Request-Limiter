<?php

/**
 * Developer : ZerosDev (http://www.zeros.co.id)
 * 
 */
 
namespace ZerosDev\RateLimiter;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RateLimiterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('RateLimiter', function() {
            return new RateLimiter;
        });
    }
}