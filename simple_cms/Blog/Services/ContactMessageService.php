<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/8/20, 1:12 AM ---------
 */

namespace SimpleCMS\Blog\Services;


use SimpleCMS\Blog\Jobs\ContactMessageJob;
use SimpleCMS\Blog\Models\ContactMessageModel;

class ContactMessageService
{

    public static function contact_message_save($request)
    {
        $field_save = apply_filter('simple_cms_contact_form_field_save');
        if (is_array($field_save) && count($field_save)) {
            $contact_message = new ContactMessageModel();
            foreach ($field_save as $value) {
                $contact_message->{$value} = filter($request->input($value));
            }
            $contact_message->save();
            $site_email = simple_cms_setting('site_email');
            $params['name']     = $contact_message->name;
            $params['email']    = $contact_message->email;
            $params['phone']    = $contact_message->phone;
            $params['website']  = $contact_message->website;
            $params['subject_message']  = $contact_message->subject;
            $params['message']  = $contact_message->message;
            $params['to']       = $site_email;
            if ($params['to'] != '' OR !empty($params['to'])){
                dispatch(new ContactMessageJob($params));
            }
        }
        $title      = __('blog::app.contact.message.success.submit_form.title');
        $message    = __('blog::app.contact.message.success.submit_form.message');
        if ($request->ajax()){
            return responseSuccess(responseMessage($message, ['title' => $title]));
        }
        return redirect()->back()->with([
           'success' => [
               'title' => $title,
               'message' => $message
           ]
        ]);
    }
}
