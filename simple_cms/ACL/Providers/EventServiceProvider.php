<?php

namespace SimpleCMS\ACL\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SimpleCMS\ACL\Events\NewRegisterAccountEvent;
use SimpleCMS\ACL\Events\PasswordResetEvent;
use SimpleCMS\ACL\Listeners\NewRegisterAccountListener;
use SimpleCMS\ACL\Listeners\PasswordResetListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewRegisterAccountEvent::class => [
            NewRegisterAccountListener::class
        ],
        PasswordResetEvent::class => [
            PasswordResetListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
