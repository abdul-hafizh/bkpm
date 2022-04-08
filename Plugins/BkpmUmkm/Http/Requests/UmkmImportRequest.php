<?php

namespace Plugins\BkpmUmkm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class UmkmImportRequest extends FormRequest
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
            'file.required' => trans('validation.file_upload_required'),
            'file.max' => Lang::get(trans('validation.file_upload_max'), ['max' => file_size(50000)]),
            'file.mimes' => Lang::get(trans('validation.file_upload_mimes'), ['mimes' => 'xls,xlsx', 'extension' => 'xls,xlsx'])
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
