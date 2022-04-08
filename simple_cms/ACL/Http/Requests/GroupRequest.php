<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:24 AM ---------
 */

namespace SimpleCMS\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
        return $this->role = [
            'name' => ['required', 'unique:groups,name,'.$this->input('id')],
        ];
    }

    /**
     * Custom message of validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return $this->message = [
            'name.required' => 'Name of group required.',
            'name.unique' => 'Name of group has taken.'
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
