<?php

namespace SimpleCMS\ACL\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $params)
    {
        $this->data = $data;
        $this->subject = 'Changed Password - ' . get_app_name();
        $this->data['subject'] = $this->subject;
        $this->data['user_agent'] = (isset($params['user_agent']) ? $params['user_agent'] : '');
        $this->data['user_ip'] = (isset($params['user_ip']) ? $params['user_ip'] : '');
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
            ->view('acl::emails.auth.passwords.reset');
    }
}
