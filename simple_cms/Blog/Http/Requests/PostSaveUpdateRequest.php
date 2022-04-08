<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 10/12/16
 * Time: 23:21
 */

namespace SimpleCMS\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostSaveUpdateRequest extends FormRequest
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
            'title'         => 'required|max:299',
            'slug'          => 'required|max:299',
            'content'       => 'required',
            'description'   => 'required|max:299',
            'type'          => 'required|in:post',
            'status'        => 'required|in:submission,rejected,draft',
            'created_at'    => 'required|date_format:d-m-Y H:i',
            'categories'    => 'required'
        ];
        if ($this->get('change_status') && trim($this->get('change_status'))!='')
        {
            return [];
        }
        if(auth()->user()->group_id <= 2){
            $this->role['user_id'] = 'required';
            $this->role['status'] .= ',publish,member';
        }
        return $this->role;
    }

    public function messages()
    {
        $this->message = [
            'title.required'        => __('blog::app.posts.request.title.required'),
            'title.max'             => __('blog::app.posts.request.title.max'),
            'slug.required'         => __('blog::app.posts.request.slug.required'),
            'slug.max'              => __('blog::app.posts.request.slug.max'),
            'content.required'      => __('blog::app.posts.request.content.required'),
            'description.required'  => __('blog::app.posts.request.description.required'),
            'description.max'       => __('blog::app.posts.request.description.max'),
            'type.required'         => __('blog::app.posts.request.type.required'),
            'type.in'               => __('blog::app.posts.request.type.in'),
            'status.required'       => __('blog::app.posts.request.status.required'),
            'status.in'             => __('blog::app.posts.request.status.in'),
            'created_at.required'   => __('blog::app.posts.request.post_date.required'),
            'created_at.date_format'=> __('blog::app.posts.request.post_date.date_format'),
            'categories.required'   => __('blog::app.posts.request.categories.required')
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
                    $validator->errors()->add('change_status', __('blog::app.posts.request.change_status.invalid'));
                }
                if (!in_array($parse_change_status[1], ['publish', 'member', 'draft', 'submission', 'rejected'])){
                    $validator->errors()->add('change_status', __('blog::app.posts.request.change_status.in'));
                }
            }
        });
        return;
    }
}
