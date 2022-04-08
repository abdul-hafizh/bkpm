<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    protected $role = [];
    protected $message = [];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->role = [
            'username' => ['required'],
            'password' => ['required']
        ];
        $this->role = array_merge($this->role, apply_filter('simple_cms_acl_add_to_validation_roles_form_login_add_filter'));
        return $this->role;
    }

    /**
     * Custom message of validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        $this->message = [
            'username.required' => 'Username or Email required.',
            'password.required' => 'Password required.'
        ];
        $this->message = array_merge($this->message, apply_filter('simple_cms_acl_add_to_validation_messages_form_login_add_filter'));
        return $this->message;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
