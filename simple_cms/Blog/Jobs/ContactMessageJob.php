<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 04 June 2020 12.23 ---------
 */


namespace SimpleCMS\Blog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SimpleCMS\Blog\Mails\ContactMessageMail;

class ContactMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $params;

    /**
     * Create a new job instance.
     *
     * @param array $params
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new ContactMessageMail($this->params);
        $send = \Mail::to($this->params['to']);
        if (isset($this->params['cc']) && $this->params['cc']){
            $send->cc($this->params['cc']);
        }
        $send->send($mail);
    }

    public function failed(\Exception $exception)
    {
        \Log::error($exception);
    }
}