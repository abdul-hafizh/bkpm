<?php

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserImportRequest extends FormRequest
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
            'file'             => ['required', 'max:50000', 'mimes:xls,xlsx']
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
            'file.required' => 'Upload file harus diisi.',
            'file.max' => 'Upload file terlalu besar.',
            'file.mimes' => 'Upload file extensi harus: xls,xlsx.'
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
