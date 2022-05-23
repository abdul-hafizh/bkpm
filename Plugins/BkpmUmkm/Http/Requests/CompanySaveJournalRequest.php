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

class CompanySaveJournalRequest extends FormRequest
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
        $company_category = CATEGORY_COMPANY;
        $this->role = [
            'activity_date'     => 'required'
        ];
        
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            
        ];

        return $this->message;
    }
}
