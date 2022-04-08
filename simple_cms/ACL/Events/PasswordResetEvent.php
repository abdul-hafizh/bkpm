<?php

namespace SimpleCMS\ACL\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEvent
{
    use Dispatchable, SerializesModels;

    public $user;
    public $params;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $params)
    {
        $this->user = $user;
        $this->params = $params;
    }
}
