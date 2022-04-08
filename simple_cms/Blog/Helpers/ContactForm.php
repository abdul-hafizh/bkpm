<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/7/20, 11:39 PM ---------
 */

/**
 * Call function
 * simple_cms_theme_contact_form_hook_action
 *
 * Hook Action
 * simple_cms_theme_contact_form_add_action
 *
 * Hook Filter
 * simple_cms_contact_form_field_save
 * simple_cms_contact_form_validation_rules
 * simple_cms_contact_form_validation_message
 * simple_cms_theme_contact_form
 *
 */

if ( ! function_exists('simple_cms_theme_contact_form_hook_action') )
{
    function simple_cms_theme_contact_form_hook_action()
    {
        return do_action('simple_cms_theme_contact_form_add_action');
    }
}

if ( ! function_exists('simple_cms_contact_form_field_save') )
{
    /**
     * @return mixed
     */
    function simple_cms_contact_form_field_save($fields)
    {
        $field = [
            'name',
            'email',
//            'phone',
//            'website',
//            'subject',
            'message'
        ];
        if ($fields && is_array($fields)){
            $field = array_merge($field, $fields);
        }
        return $field;
    }
}
add_filter('simple_cms_contact_form_field_save', 'simple_cms_contact_form_field_save', 1);

if ( ! function_exists('simple_cms_contact_form_validation_rules') )
{
    /**
     * @return mixed
     */
    function simple_cms_contact_form_validation_rules($rules)
    {
        $rule = [
            'name'      => 'required|min:5|max:191',
            'email'     => 'required|email|min:5|max:191',
//            'phone'     => 'required|min:5|max:14',
//            'website'   => 'required|url|min:5|max:191',
//            'subject'   => 'required|min:5|max:250',
            'message'   => 'required|min:50|max:600'
//            'captcha'   => 'required|captcha'
        ];
        if ($rules && is_array($rules)){
           $rule = array_merge($rule, $rules);
        }
        return $rule;
    }
}
add_filter('simple_cms_contact_form_validation_rules', 'simple_cms_contact_form_validation_rules', 1);

if ( ! function_exists('simple_cms_contact_form_validation_message') )
{
    /**
     * @return mixed
     */
    function simple_cms_contact_form_validation_message($messages)
    {
        $message = [
            'name.required'     => __('blog::app.contact.request.name.required'),
            'name.min'          => __('blog::app.contact.request.name.min'),
            'name.max'          => __('blog::app.contact.request.name.max'),
            'email.required'    => __('blog::app.contact.request.email.required'),
            'email.email'       => __('blog::app.contact.request.email.email'),
            'email.min'         => __('blog::app.contact.request.email.min'),
            'email.max'         => __('blog::app.contact.request.email.max'),
            'phone.required'    => __('blog::app.contact.request.phone.required'),
            'phone.min'         => __('blog::app.contact.request.phone.min'),
            'phone.max'         => __('blog::app.contact.request.phone.max'),
            'website.required'  => __('blog::app.contact.request.website.required'),
            'website.url'       => __('blog::app.contact.request.website.url'),
            'website.min'       => __('blog::app.contact.request.website.min'),
            'website.max'       => __('blog::app.contact.request.website.max'),
            'subject.required'  => __('blog::app.contact.request.subject.required'),
            'subject.min'       => __('blog::app.contact.request.subject.min'),
            'subject.max'       => __('blog::app.contact.request.subject.max'),
            'message.required'  => __('blog::app.contact.request.message.required'),
            'message.min'       => __('blog::app.contact.request.message.min'),
            'message.max'       => __('blog::app.contact.request.message.max')
//            'captcha.required'  => __('blog::app.contact.request.captcha.required'),
//            'captcha.captcha'   => __('blog::app.contact.request.captcha.captcha')
        ];

        if ($messages && is_array($messages)){
            $message = array_merge($message, $messages);
        }
        return $message;
    }
}
add_filter('simple_cms_contact_form_validation_message', 'simple_cms_contact_form_validation_message', 1);


if ( ! function_exists('simple_cms_theme_contact_form') )
{
    /**
     * @return mixed
     */
    function simple_cms_theme_contact_form()
    {
        \Theme::asset()->container('footer')->usePath()->add('contact-form-js', 'js/contact-form.js');
        return view('theme.'.themeActive().'::views.contact_form');
    }
}
add_filter('simple_cms_theme_contact_form', 'simple_cms_theme_contact_form');
