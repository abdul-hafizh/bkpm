<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Slider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderCreateUpdateRequest extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!$this->get('sorter') && $this->get('sorter') == '') {
            $id = encrypt_decrypt(filter($this->input('id')), 2);
            $this->role = [
                'title' => 'required',
//                'description' => 'required',
//                'file' => 'required',
            ];
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'title.required' => 'Title slider required.',
            'title.unique' => 'Title slider duplicate.',
            'description.required' => 'Deskripsi harus diisi.',
            'file.required' => 'Cover harus diisi.',
        ];
        return $this->message;
    }
}
