<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfileRequest extends FormRequest
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
//            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username,'.$id],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users,email,'.$id],
            'id_negara' => ['required'],
            'id_provinsi' => ['required'],
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

            'id_negara.required' => 'Country required.',
            'id_provinsi.required' => 'Province required.',
            'gender.required' => 'Please select gender.',

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
