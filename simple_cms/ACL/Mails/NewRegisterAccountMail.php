<?php

namespace SimpleCMS\ACL\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewRegisterAccountMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->subject = 'New Register Account - ' . get_app_name();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->data->email, $this->data->name)
            //->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('acl::emails.auth.register');
    }
}
