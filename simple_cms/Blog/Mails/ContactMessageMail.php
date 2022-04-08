<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 04 June 2020 12.24 ---------
 */


namespace SimpleCMS\Blog\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->data = $params;
        $this->subject = 'Pesan dari: '. $params['name'] .' - ' . get_app_name();
        $this->data['subject'] = $this->subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (view()->exists('theme_active::views.mails.contact_message')){
            return $this->view('theme_active::views.mails.contact_message');
        }
        return $this->view('blog::mails.contact_message');
    }
}