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

class UmkmPotensialSaveUpdateRequest extends FormRequest
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
        $pic_id = encrypt_decrypt(filter($this->input('pic_id')), 2);
        $id_provinsi = filter($this->input('id_provinsi'));
        $company_category = CATEGORY_UMKM;
        $this->role = [            
            'name'  => "required",
            'code_kbli' => 'required',
            'email'         => 'required|email',
            'id_negara'     => 'required',
            'id_provinsi'   => 'required',
            'name_pic' => 'required',
            'email_pic' => "required|email|unique:users,email,{$pic_id}",
            'phone_pic' => "required|unique:users,mobile_phone,{$pic_id}",
        ];
        if ($this->has('business_sector_id') && $this->input('business_sector_id')) {
            $this->role['business_sector_id'] = 'required|exists:business_sectors,id';
        }
        if (!$pic_id){
            $this->role['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        if ($this->has('code') && $this->input('code')){
            $this->role['code'] = "unique:companies,code,{$id},id,category,{$company_category}";
        }
        if ($this->has('npwp') && $this->input('npwp')){
            $this->role['npwp'] = "unique:companies,npwp,{$id},id,category,{$company_category}";
        }
        if ($this->has('nib') && $this->input('nib')){
            $this->role['nib'] = "unique:companies,nib,{$id},id,category,{$company_category}";
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'name.required' => Lang::get(trans('validation.umkm_name_required')),
            'name.unique' => Lang::get(trans('validation.umkm_name_unique')),
            'type.required'  => Lang::get(trans('validation.umkm_type_required')),
            'business_sector_id.required' => Lang::get(trans('validation.umkm_sector_required')),
            'business_sector_id.exists' => Lang::get(trans('validation.sector_not_exists')),
            'code_kbli.required' => Lang::get(trans('validation.umkm_code_kbli_required')),
            'code_kbli.exists' => Lang::get(trans('validation.umkm_code_kbli_not_exists')),
            'email.required'         => Lang::get(trans("validation.umkm_email_required")),
            'email.email'         => Lang::get(trans("validation.umkm_email_email")),
            'id_negara.required'     => Lang::get(trans("validation.umkm_country_required")),
            'id_provinsi.required'     => Lang::get(trans("validation.umkm_provinsi_required")),
            'name_director.required'  => Lang::get(trans("validation.umkm_name_director_of_umkm_required")),
            'name_pic.required' => Lang::get(trans("validation.umkm_name_pic_of_umkm_required")),
            'email_pic.required' => Lang::get(trans("validation.umkm_email_pic_of_umkm_required")),
            'email_pic.email' => Lang::get(trans("validation.umkm_email_pic_of_umkm_email")),
            'email_pic.unique' => Lang::get(trans("validation.umkm_email_pic_of_umkm_unique")),
            'total_employees.required'=> Lang::get(trans("validation.umkm_total_employees_required")),
            'infrastructure.required' => Lang::get(trans("validation.umkm_infrastructure_required")),
            'net_worth.required' => Lang::get(trans("validation.umkm_net_worth_required")),
            'omset_every_year.required' => Lang::get(trans("validation.umkm_omset_every_year_required")),
            'estimated_venture_capital.required' => Lang::get(trans("validation.umkm_estimated_venture_capital_required")),
            'password.required'     => Lang::get(trans("validation.umkm_password_required")),
            'password.string'     => Lang::get(trans("validation.umkm_password_string")),
            'password.min'     => Lang::get(trans("validation.umkm_password_min")),
            'password.confirmed'     => Lang::get(trans("validation.umkm_password_confirmed")),
            'code.unique'     => Lang::get(trans("validation.umkm_code_unique")),
            'npwp.unique'     => Lang::get(trans("validation.umkm_npwp_unique")),
            'nib.unique'     => Lang::get(trans("validation.umkm_nib_unique"))
        ];

        return $this->message;
    }

}
