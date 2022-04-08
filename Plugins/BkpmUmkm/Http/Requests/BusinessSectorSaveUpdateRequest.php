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

class BusinessSectorSaveUpdateRequest extends FormRequest
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
            'name' => 'required|unique:business_sectors,name,' . $id
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'name.required' => Lang::get(trans('validation.required'), ['attribute' => trans('label.index_business_sector')]),
            'name.unique' => Lang::get(trans('validation.unique'), ['attribute' => trans('label.index_business_sector')])
        ];
        return $this->message;
    }
}
