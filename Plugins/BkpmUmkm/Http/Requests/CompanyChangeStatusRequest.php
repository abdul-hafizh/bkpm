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

class CompanyChangeStatusRequest extends FormRequest
{
    protected $role;
    protected $message;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->role = [
            'status'  => "required|in:".encrypt_decrypt('bersedia').",".encrypt_decrypt('tidak_bersedia').",".encrypt_decrypt('tidak_respon').",".encrypt_decrypt('konsultasi_bkpm').",".encrypt_decrypt('menunggu_konfirmasi')
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'status.required' => Lang::get(trans('validation.required'), ['attribute' => trans('label.status')]),
            'status.in' => Lang::get(trans('validation.in'), ['attribute' => trans('label.status')])
        ];

        return $this->message;
    }
}
