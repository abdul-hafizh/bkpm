<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            /*'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username'],*/
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required']
        ];
        $this->role = array_merge($this->role, apply_filter('simple_cms_acl_add_to_validation_roles_form_register_add_filter'));
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
            'username.required' => 'Username required.',
            'username.string' => 'Username must be string or text.',
            'username.alpha_dash' => 'Username allows letters, numbers, dashes and underscores and NOT space.',
            'username.max' => 'Username max 50.',
            'username.unique' => 'Try other username.',

            'name.required' => 'Full name required.',
            'name.string' => 'Full name must be string or text.',
            'name.max' => 'Full name max 150.',

            'email.required' => 'Email required.',
            'email.string' => 'Email must be string or text.',
            'email.email' => 'Format email please correct.',
            'email.max' => 'Email max 70.',
            'email.unique' => 'Email already has taken.',

            /*'no_mobile.required' => 'No Handphone required.',
            'address.required' => 'Alamat required.',
            'city.required' => 'Kota required.',
            'postal_code.required' => 'Kode Pos required.',*/

            'password.required' => 'Password required.',
            'password.string' => 'Password must be string or text.',
            'password.min' => 'Password min length 8.',
            'password.confirmed' => 'Confirmation password not match.',

            'terms.required' => 'Please check agree to the terms.'
        ];
        $this->message = array_merge($this->message, apply_filter('simple_cms_acl_add_to_validation_messages_form_register_add_filter'));
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
