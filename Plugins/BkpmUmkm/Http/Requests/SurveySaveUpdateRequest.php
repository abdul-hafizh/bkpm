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

class SurveySaveUpdateRequest extends FormRequest
{
    protected $role;
    protected $message;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->role = [
            'company_id' => 'required',
            'surveyor_id' => 'required',
            'estimated_date' => 'required'
        ];
        return $this->role;
    }

    public function messages()
    {
        $category_company = $this->route()->parameter('company');
        $this->message = [
            'company_id.required' => Lang::get(trans("validation.survey_{$category_company}_required")),
            'surveyor_id.unique' => Lang::get(trans('validation.survey_surveyor_required')),
            'estimated_date.required' => Lang::get(trans('validation.survey_estimated_date_required'))
        ];
        return $this->message;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        // checks user current password
        // before making changes
        $validator->after(function ($validator) {
            $category_company = $this->route()->parameter('company');
            $company_id = filter($this->input('company_id'));
            $surveyor_id = encrypt_decrypt(filter($this->input('surveyor_id')), 2);
            $surveyor = \SimpleCMS\ACL\Models\User::where('id', $surveyor_id)->first();
            $event      = $this->get('event');
            $event      = encrypt_decrypt($event, 2);
            if (!$surveyor_id){
                $validator->errors()->add('surveyor_id', trans('validation.survey_surveyor_not_found'));
            }
            if ($surveyor && empty($surveyor->id_provinsi)){
                $validator->errors()->add('surveyor_id', trans('validation.survey_surveyor_regional_not_found'));
            }
            /*if ($surveyor && $surveyor->id_provinsi) {
                $provinces = bkpmumkm_wilayah($surveyor->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $company = \Plugins\BkpmUmkm\Models\CompanyModel::where('id', $company_id)->first();
                if ($company && !in_array($company->id_provinsi, $provinces)){
                    $validator->errors()->add('surveyor_id', trans('validation.survey_surveyor_not_in_regional'));
                }
            }*/
            if ($event == 'add') {
                $check_has_survey = \Plugins\BkpmUmkm\Models\SurveyModel::where('company_id', $company_id)->whereYear('created_at', Carbon::now()->format('Y'))->first();
                if ($check_has_survey && $check_has_survey->surveyor_id) {
                    $validator->errors()->add('company_id', trans("validation.survey_{$category_company}_has_been_surveyed"));
                }
            }
        });
        return;
    }
}
