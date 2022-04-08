<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $id = encrypt_decrypt(filter($this->input('id')), 2);
        $this->role = [
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username,'.$id],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:70', 'unique:users,email,'.$id],
            'group_id' => 'required',
            'role_id' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ];
        if (!empty($id) && (!$this->has('password') OR !$this->input('password'))){
            unset($this->role['password']);
        }
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

            'group_id.required' => 'Group required.',
            'role_id.required' => 'Role required.',

            'password.required' => 'Password required.',
            'password.string' => 'Password must be string or text.',
            'password.min' => 'Password min length 8.',
            'password.confirmed' => 'Confirmation password not match.',
        ];
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
