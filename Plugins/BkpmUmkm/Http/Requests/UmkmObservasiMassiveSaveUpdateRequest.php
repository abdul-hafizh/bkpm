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

class UmkmObservasiMassiveSaveUpdateRequest extends FormRequest
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
        $id = encrypt_decrypt(filter($this->input('id')), 2);
        $id_provinsi = filter($this->input('id_provinsi'));
        $this->role = [
            'name'  => "required|unique:umkm_massive,name,{$id},id,nib,{$this->input('nib')},id_provinsi,{$id_provinsi}",
            'code_kbli' => 'required|exists:kbli,code',
            'id_negara'     => 'required',
            'id_provinsi'   => 'required',
            'name_director'  => 'required'
        ];
        if ($this->has('nib') && $this->input('nib')){
            $this->role['nib'] = "unique:umkm_massive,nib,{$id}";
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'name.required' => Lang::get(trans('validation.umkm_name_required')),
            'name.unique' => Lang::get(trans('validation.umkm_name_unique')),
            'id_negara.required'     => Lang::get(trans("validation.umkm_country_required")),
            'id_provinsi.required'     => Lang::get(trans("validation.umkm_provinsi_required")),
            'name_director.required'  => Lang::get(trans("validation.umkm_name_director_of_umkm_required")),
            'code_kbli.required' => Lang::get(trans('validation.umkm_code_kbli_required')),
            'code_kbli.exists' => Lang::get(trans('validation.umkm_code_kbli_not_exists')),
            'nib.unique'     => Lang::get(trans("validation.umkm_nib_unique"))
        ];

        return $this->message;
    }

}
