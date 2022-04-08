<?php

namespace SimpleCMS\ACL\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use SimpleCMS\ACL\Mails\ChangePasswordResetMail;

class PasswordResetListener
{
    use InteractsWithQueue;
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 10;

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::send(new ChangePasswordResetMail($event->user, $event->params));
    }

    /**
     * Handle a job failure.
     *
     * @param  object  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed($event, $exception)
    {
        \Log::error($exception);
        \Log::alert("Send email to: {$event->user->name} [{$event->user->email}] failed.");
    }
}
