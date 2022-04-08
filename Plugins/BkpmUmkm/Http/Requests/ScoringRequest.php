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

class ScoringRequest extends FormRequest
{
    protected $role = [];
    protected $message = [];
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (!$this->get('in_modal')) {
            $this->role = [
                'scoring' => 'required'
            ];
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'scoring.required' => Lang::get(trans('validation.required'))
        ];
        return $this->message;
    }
}
