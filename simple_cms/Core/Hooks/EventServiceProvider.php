<?php

namespace SimpleCMS\Core\Hooks;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Registers the eventy singleton.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('hook', function ($app) {
            return new Events();
        });
    }
}
