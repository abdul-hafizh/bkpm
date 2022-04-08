<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 9:58 AM ---------
 */

if ( ! function_exists('captcha_template_form_input_default') )
{
    function captcha_template_form_input_default()
    {
        \Core::asset()->add('captcha-js', plugins_asset('captcha', 'js/captcha.js'));
        \Theme::asset()->usePath(false)->add('captcha-js', plugins_asset('captcha', 'js/captcha.js'));
        echo '<div class="form-group m-b-20">
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="pointer-cursor" id="refresh-captcha" title="Click for refresh captcha" style="cursor:pointer;">
                                <img id="img-captcha" src="'. module_asset('core', 'images/loader-35.gif') .'"/>
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" name="captcha" placeholder="captcha" class="form-control" required autocomplete="off">
                        </div>
                    </div>
                </div>';
        return;
    }
}

if ( ! function_exists('captcha_template_form_input_frontend') )
{
    function captcha_template_form_input_frontend()
    {
        \Theme::asset()->usePath(false)->add('captcha-js', plugins_asset('captcha', 'js/captcha.js'));
        echo '<div class="row">
                    <div class="col-lg-4">
                        <a class="pointer-cursor" id="refresh-captcha" title="Click for refresh captcha" style="cursor:pointer;">
                            <img id="img-captcha" class="image-border" src="'. module_asset('core', 'images/loader-35.gif') .'"/>
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <input type="text" name="captcha" placeholder="captcha" class="form-control form-neoboots" required autocomplete="off">
                        </div>
                    </div>
                </div>';
        return;
    }
}

if ( ! function_exists('simple_cms_captcha_validation_rules') )
{
    /**
     * @return mixed
     */
    function simple_cms_captcha_validation_rules($rules)
    {
        $rule = [
            'captcha'   => 'required|captcha'
        ];
        if ($rules && is_array($rules)){
            $rule = array_merge($rule, $rules);
        }
        return $rule;
    }
}
if ( ! function_exists('simple_cms_captcha_validation_messages') )
{
    /**
     * @return mixed
     */
    function simple_cms_captcha_validation_messages($messages)
    {
        $message = [
            'captcha.required'  => __('blog::app.contact.request.captcha.required'),
            'captcha.captcha'   => __('blog::app.contact.request.captcha.captcha')
        ];

        if ($messages && is_array($messages)){
            $message = array_merge($message, $messages);
        }
        return $message;
    }
}
$captcha_support_forms = simple_cms_setting('captcha_support_forms', json_encode(app('config')->get('plugins.captcha.support_form')));
if(is_array($captcha_support_forms)) {
    foreach ($captcha_support_forms as $form) {
        if ($form['enable'] && !empty($form['add_action']) && !empty($form['add_filter_rules']) && !empty($form['add_filter_messages'])) {
            add_action($form['add_action'], $form['function_callback']);

            add_filter($form['add_filter_rules'], 'simple_cms_captcha_validation_rules');
            add_filter($form['add_filter_messages'], 'simple_cms_captcha_validation_messages');
        }
    }
}
