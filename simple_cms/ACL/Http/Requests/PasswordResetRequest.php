<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email' => 'required|email'
        ];
        $this->role = array_merge($this->role, apply_filter('simple_cms_acl_add_to_validation_roles_form_reset_password_add_filter'));
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
            'email.required' => 'Email required.',
            'email.email' => 'Format email please correct.'
        ];
        $this->message = array_merge($this->message, apply_filter('simple_cms_acl_add_to_validation_messages_form_reset_password_add_filter'));
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
