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

class TargetSaveUpdateRequest extends FormRequest
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
            'tahun' => 'required|unique:target,tahun,' . $id
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'target_UB.required' => Lang::get(trans('validation.required')),
            'target_umkm.required' => Lang::get(trans('validation.required')),
            'target_value.required' => Lang::get(trans('validation.required')),
            'tahun.unique' => Lang::get(trans('validation.unique'))
        ];
        return $this->message;
    }
}
