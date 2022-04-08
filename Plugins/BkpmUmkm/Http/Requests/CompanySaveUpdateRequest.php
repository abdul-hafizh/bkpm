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

class CompanySaveUpdateRequest extends FormRequest
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
        $company_category = CATEGORY_COMPANY;
        $this->role = [
            'name'  => "required|unique:companies,name,{$id},id,category,{$company_category},id_provinsi,{$id_provinsi}",
//            'type'  => 'required',
//            'business_sector_id' => 'required|exists:business_sectors,id',
            /*'directorate'   => 'required',*/
//            'pmdn_pma'      => 'required|in:'.implode(',', $config['pmdn_pma']),
            'id_negara'     => 'required',
            'id_provinsi'     => 'required',
//            'name_director'  => 'required',
//            'total_employees'=> 'required',
//            'investment_plan' => 'required'
        ];
        if ($this->has('business_sector_id') && !empty($this->input('business_sector_id')) ){
            $this->role['business_sector_id'] = 'required|exists:business_sectors,id';
        }
        /*if ($this->has('code_kbli') && !empty($this->input('code_kbli')) ){
            $this->role['code_kbli'] = 'exists:kbli,code';
        }*/
        if ($this->has('email') && !empty($this->input('email')) ){
            $this->role['email'] = 'email';
        }
        if ($this->has('pmdn_pma') && !empty($this->input('pmdn_pma')) ){
            $this->role['pmdn_pma'] = 'required|in:'.implode(',', $config['pmdn_pma']);

            if ( $this->input('pmdn_pma') == 'PMA' ){
                $this->role['pma_negara_id'] = 'required';
            }
        }

        if ($this->has('code') && !empty($this->input('code')) ){
            $this->role['code'] = "unique:companies,code,$id,id,category,{$company_category}";
        }
        if ($this->has('npwp') && !empty($this->input('npwp')) ){
            $this->role['npwp'] = "unique:companies,npwp,$id,id,category,{$company_category}";
        }
        if ($this->has('nib') && !empty($this->input('nib')) ){
            $this->role['nib'] = "unique:companies,nib,$id,id,category,{$company_category}";
        }

        if ($this->has('email_pic') && !empty($this->input('email_pic')) ){
            $this->role['email_pic'] = "email|unique:users,email,{$pic_id}";
        }
        if ($this->has('phone_pic') && !empty($this->input('phone_pic')) ){
            $this->role['phone_pic'] = "unique:users,mobile_phone,{$pic_id}";
        }
        if ($this->has('password') && !empty($this->input('password')) ){
            $this->role['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            /*'code.required' => Lang::get(trans('validation.required')),
            'code.unique' => Lang::get(trans('validation.unique')),*/
            'name.required' => Lang::get(trans('validation.company_name_required')),
            'name.unique' => Lang::get(trans('validation.company_name_unique')),
            'type.required'  => Lang::get(trans('validation.company_type_required')),
            'business_sector_id.required' => Lang::get(trans('validation.company_sector_required')),
            'business_sector_id.exists' => Lang::get(trans('validation.sector_not_exists')),
            'code_kbli.required' => Lang::get(trans('validation.company_code_kbli_required')),
            'code_kbli.exists' => Lang::get(trans('validation.company_code_kbli_not_exists')),
            'directorate.required'   => Lang::get(trans('validation.company_directorate_required')),
            'pmdn_pma.required'          => Lang::get(trans('validation.company_pmdn_pma_required')),
            'pmdn_pma.in'          => Lang::get(trans('validation.company_pmdn_pma_in')),
            'email.required'         => Lang::get(trans("validation.company_email_required")),
            'email.email'         => Lang::get(trans("validation.company_email_email")),
            'id_negara.required'     => Lang::get(trans("validation.company_country_required")),
            'id_provinsi.required'     => Lang::get(trans("validation.company_provinsi_required")),
            'name_director.required'  => Lang::get(trans("validation.company_name_director_of_company_required")),
            'name_pic.required' => Lang::get(trans("validation.company_name_pic_of_company_required")),
            'email_pic.required' => Lang::get(trans("validation.company_email_pic_of_company_required")),
            'email_pic.email' => Lang::get(trans("validation.company_email_pic_of_company_email")),
            'email_pic.unique' => Lang::get(trans("validation.company_email_pic_of_company_unique")),
            'logo.required'           => Lang::get(trans("validation.company_logo_required")),
            'total_employees.required'=> Lang::get(trans("validation.company_total_employees_required")),
            'investment_plan.required' => Lang::get(trans("validation.company_investment_plan_required")),
            'password.required'     => Lang::get(trans("validation.company_password_required")),
            'password.string'     => Lang::get(trans("validation.company_password_string")),
            'password.min'     => Lang::get(trans("validation.company_password_min")),
            'password.confirmed'     => Lang::get(trans("validation.company_password_confirmed")),
            'code.unique'     => Lang::get(trans("validation.company_code_unique")),
            'npwp.unique'     => Lang::get(trans("validation.company_npwp_unique")),
            'nib.unique'     => Lang::get(trans("validation.company_nib_unique")),
            'pma_negara_id.required'     => Lang::get(trans("validation.required"), ['attribute' => trans('label.pma_negara')]),
        ];

        return $this->message;
    }
}
