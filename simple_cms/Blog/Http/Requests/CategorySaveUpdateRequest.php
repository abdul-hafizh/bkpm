<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorySaveUpdateRequest extends FormRequest
{
    protected $role;
    protected $message;

    public function rules()
    {
        // $id = encrypt_decrypt(filter($this->input('id')), 2);
        $this->role = [
            // 'name' => 'required|unique:categories,name,'.(is_null($id) ? 'NULL':$id)
            'name' => 'required'
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'name.required' => __('blog::app.category.request.name.required'),
            'name.unique' => __('blog::app.category.request.name.unique')
        ];
        return $this->message;
    }


    public function authorize()
    {
        return true;
    }
}
