<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/20/20, 6:14 AM ---------
 */

/*
 * Function
 * - simple_cms_core_backend_setting_locale_date_to_general
 * - simple_cms_core_backend_setting_force_https_to_general
 * - simple_cms_core_backend_setting_url_not_allowed_to_general
 * */

/** Locale Date **/
if ( ! function_exists('simple_cms_core_backend_setting_locale_date_to_general') )
{
    function simple_cms_core_backend_setting_locale_date_to_general()
    {
        $value = simple_cms_setting('locale_date', 'id');
        echo '<div class="form-group">
                    <label for="setting-locale_date">Locale Date</label>
                    <select id="setting-locale_date" class="form-control form-control-sm" name="settings[locale_date]">
                        <option value="id" '.($value=='id' ? 'selected':'').'>ID</option>
                        <option value="en" '.($value=='en' ? 'selected':'').'>EN</option>
                    </select>
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_general_left_add_action', 'simple_cms_core_backend_setting_locale_date_to_general');

/** Force Https **/
if ( ! function_exists('simple_cms_core_backend_setting_force_https_to_general') )
{
    function simple_cms_core_backend_setting_force_https_to_general()
    {
        $value = simple_cms_setting('force_https', '0');
        echo '<div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input checkboxDefault" type="checkbox" id="setting-force_https" name="settings[force_https]" value="1" '.($value=="1" ? 'checked':'').'>
                        <input type="hidden" name="settings[force_https]" value="0">
                        <label for="setting-force_https" class="custom-control-label">Force/Enable https?</label>
                    </div>
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_general_left_add_action', 'simple_cms_core_backend_setting_force_https_to_general');

/** Regex URL not allowed in Post **/
if ( ! function_exists('simple_cms_core_backend_setting_url_not_allowed_to_general') )
{
    function simple_cms_core_backend_setting_url_not_allowed_to_general()
    {
        $value = simple_cms_setting('blog_url_not_allowed');
        echo '<div class="form-group">
                    <label for="setting-blog_url_not_allowed">Segment url not allowed <strong class="text-danger">*</strong></label>
                    <input id="setting-blog_url_not_allowed" type="text" name="settings[blog_url_not_allowed]" value="'.$value.'" data-counter="100" placeholder="eg: backend,admin,auth,wilayah,captcha,archive,category,search,tag" class="form-control form-control-sm" required>
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_general_left_add_action', 'simple_cms_core_backend_setting_url_not_allowed_to_general');
