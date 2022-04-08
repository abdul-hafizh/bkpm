<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageSaveUpdateRequest extends FormRequest
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
            'title'     => 'required|max:299',
            'slug'      => 'required|max:299',
            'description'   => 'required|max:299',
            'content'   => 'required',
            'type'      => 'required|in:page',
            'status'    => 'required|in:publish,member,draft',
            'created_at'=> 'required|date_format:d-m-Y H:i'
        ];
        if ($this->get('change_status') && trim($this->get('change_status'))!='')
        {
            return [];
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'title.required'        => __('blog::app.pages.request.title.required'),
            'title.max'             => __('blog::app.pages.request.title.max'),
            'slug.required'         => __('blog::app.pages.request.slug.required'),
            'slug.max'              => __('blog::app.pages.request.slug.max'),
            'description.required'  => __('blog::app.posts.request.description.required'),
            'description.max'       => __('blog::app.posts.request.description.max'),
            'content.required'      => __('blog::app.pages.request.content.required'),
            'type.required'         => __('blog::app.pages.request.type.required'),
            'type.in'               => __('blog::app.pages.request.type.in'),
            'status.required'       => __('blog::app.pages.request.status.required'),
            'status.in'             => __('blog::app.pages.request.status.in'),
            'created_at.required'   => __('blog::app.pages.request.post_date.required'),
            'created_at.date_format'=> __('blog::app.pages.request.post_date.date_format')
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
            if ($this->get('change_status') && trim($this->get('change_status'))!='')
            {
                $parse_change_status = encrypt_decrypt(trim($this->get('change_status')), 2);
                $parse_change_status = explode('|', $parse_change_status);
                if (count($parse_change_status) !== 2){
                    $validator->errors()->add('change_status', __('blog::app.pages.request.change_status.invalid'));
                }
                if (!in_array($parse_change_status[1], ['publish', 'member', 'draft'])){
                    $validator->errors()->add('change_status', __('blog::app.pages.request.change_status.in'));
                }
            }
        });
        return;
    }
}
