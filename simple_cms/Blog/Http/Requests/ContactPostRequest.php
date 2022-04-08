<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactPostRequest extends FormRequest
{
    protected $role;
    protected $message;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->role = apply_filter('simple_cms_contact_form_validation_rules');
        return $this->role;
    }

    public function messages()
    {
        $this->message = apply_filter('simple_cms_contact_form_validation_message');
        return $this->message;
    }
}
