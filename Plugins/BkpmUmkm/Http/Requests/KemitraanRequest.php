<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace Plugins\BkpmUmkm\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class KemitraanRequest extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->file('file_kerjasama')) {
            $this->role['file_kerjasama'] = [
                'required',
                'max:15000',
                'mimes:pdf'
            ];
        }

        if ($this->file('file_kontrak')) {
            $this->role['file_kontrak'] = [
                'required',
                'max:15000',
                'mimes:pdf'
            ];
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'file_kerjasama.required'   => 'File Kerjasama harus diisi.',
            'file_kerjasama.max'   => 'File Kerjasama terlalu besar.',
            'file_kerjasama.mimes' => 'Extensi File Kerjasama tidak didukung.',

            'file_kontrak.required'   => 'File Kontrak harus diisi.',
            'file_kontrak.max'   => 'File Kontrak terlalu besar.',
            'file_kontrak.mimes' => 'Extensi File Kontrak tidak didukung.'
        ];
        return $this->message;
    }
}
