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

class UmkmObservasiSaveUpdateRequest extends FormRequest
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
        $company_category = CATEGORY_UMKM;
        $this->role = [
            'name'  => "required|unique:companies,name,{$id},id,category,{$company_category},id_provinsi,{$id_provinsi}",
            'id_negara'     => 'required',
            'id_provinsi'   => 'required',
            'name_director'  => 'required'
            // 'surveyor_observasi_id' => 'required'
        ];
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'name.required' => Lang::get(trans('validation.umkm_name_required')),
            'name.unique' => Lang::get(trans('validation.umkm_name_unique')),
            'id_negara.required'     => Lang::get(trans("validation.umkm_country_required")),
            'id_provinsi.required'     => Lang::get(trans("validation.umkm_provinsi_required")),
            'name_director.required'  => Lang::get(trans("validation.umkm_name_director_of_umkm_required"))
            // 'surveyor_observasi_id.required' => Lang::get(trans("validation.umkm_name_surveyor_observasi_required"))
        ];

        return $this->message;
    }

}
