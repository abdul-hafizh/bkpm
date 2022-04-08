<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuSaveUpdateRequest extends FormRequest
{
    protected $role = [];
    protected $message;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = encrypt_decrypt(filter($this->input('id')), 2);
        $this->role = [
            'name'  => 'required|unique:menus,name,' . $id,
            'option'=> 'required'
        ];
        return $this->role;
    }
    
    public function messages()
    {
        $this->message = [
            'name.required'     => 'Menu name required.',
            'name.unique'       => 'Menu name already exists.',
            'option.required'   => 'Menu empty, please make menu item.'
        ];
        return $this->message;
    }
}