<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagSaveUpdateRequest extends FormRequest
{
    protected $role;
    protected $message;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = encrypt_decrypt(filter($this->input('id')), 2);
        if ($id) {
            $this->role = [
                'name' => 'required|unique:tags,name,' . (is_null($id) ? 'NULL' : $id)
            ];
        }else{
            $this->role = [
                'name' => 'required'
            ];
        }
        return $this->role;
    }
    
    public function messages()
    {
        $this->message = [
            'name.required' => 'Tag name required.',
            'name.unique' => 'Tag name already exists.'
        ];
        return $this->message;
    }
}