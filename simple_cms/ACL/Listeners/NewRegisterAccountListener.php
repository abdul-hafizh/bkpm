<?php

namespace SimpleCMS\ACL\Listeners;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use SimpleCMS\ACL\Mails\NewRegisterAccountMail;

class NewRegisterAccountListener
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
        if (account_verify() && $event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
            $event->user->sendEmailVerificationNotification();
        }
        Mail::send(new NewRegisterAccountMail($event->user));
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
