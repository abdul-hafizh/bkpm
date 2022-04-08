<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
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
        $id = auth()->user()->id;
        $this->role = [
            'current_password' => 'required',
        ];
        return $this->role;
    }

    /**
     * Custom message of validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return $this->message = [
            'current_password.required' => 'Please enter current password.'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // checks user current password
        // before making changes
        $validator->after(function ($validator) {
            if ( !empty($this->input('password')) && Hash::check($this->input('password'), $this->user()->password) ) {
                $validator->errors()->add('password', 'New password same with old password.');
            }
            if ( !Hash::check($this->input('current_password'), $this->user()->password) ) {
                $validator->errors()->add('current_password', 'Your current password is incorrect.');
            }
        });
        return;
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
