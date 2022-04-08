<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace Plugins\BkpmUmkm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class KbliSaveUpdateRequest extends FormRequest
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
        $this->role = [
            'code' => 'required|unique:kbli,code,' . $id,
            'name' => 'required|unique:kbli,name,' . $id
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'code.required' => Lang::get(trans('validation.required')),
            'code.unique' => Lang::get(trans('validation.unique')),
            'name.required' => Lang::get(trans('validation.required')),
            'name.unique' => Lang::get(trans('validation.unique'))
        ];
        return $this->message;
    }
}
