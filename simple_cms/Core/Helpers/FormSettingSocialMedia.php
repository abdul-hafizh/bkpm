<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/20/20, 6:14 AM ---------
 */

/**
 * Function add to hook action
 * - simple_cms_core_backend_setting_social_facebook_to_contact_information
 * - simple_cms_core_backend_setting_social_twitter_to_contact_information
 * - simple_cms_core_backend_setting_twitter_username_to_contact_information
 * - simple_cms_core_backend_setting_social_instagram_to_contact_information
 * - simple_cms_core_backend_setting_social_linkedin_to_contact_information
**/

/* Setting Social Network */
/** Facebook **/
if ( ! function_exists('simple_cms_core_backend_setting_social_facebook_to_contact_information') )
{
    function simple_cms_core_backend_setting_social_facebook_to_contact_information()
    {
        $value = simple_cms_setting('site_social_facebook', '');
        echo '<div class="form-group">
                    <label for="setting-site_social_facebook">Facebook</label>
                    <input id="setting-site_social_facebook" class="form-control form-control-sm" placeholder="Url Facebook" name="settings[site_social_facebook]" type="text" value="'.$value.'">
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_contact_information_right_add_action', 'simple_cms_core_backend_setting_social_facebook_to_contact_information');

/** Twitter **/
if ( ! function_exists('simple_cms_core_backend_setting_social_twitter_to_contact_information') )
{
    function simple_cms_core_backend_setting_social_twitter_to_contact_information()
    {
        $value = simple_cms_setting('site_social_twitter', '');
        echo '<div class="form-group">
                    <label for="setting-site_social_twitter">Twitter</label>
                    <input id="setting-site_social_twitter" class="form-control form-control-sm" placeholder="Url Twitter" name="settings[site_social_twitter]" type="text" value="'.$value.'">
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_contact_information_right_add_action', 'simple_cms_core_backend_setting_social_twitter_to_contact_information');

/** Twitter Username **/
if ( ! function_exists('simple_cms_core_backend_setting_twitter_username_to_contact_information') )
{
    function simple_cms_core_backend_setting_twitter_username_to_contact_information()
    {
        $value = simple_cms_setting('twitter_username', 'Whendy_Takashy');
        echo '<div class="form-group">
                <label for="setting-twitter_username">Twitter Username (For SEO Twitter)</label>
                <input id="setting-twitter_username" class="form-control form-control-sm" placeholder="Twitter Username" name="settings[twitter_username]" type="text" value="'.$value.'">
            </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_contact_information_right_add_action', 'simple_cms_core_backend_setting_twitter_username_to_contact_information');

/** Instagram **/
if ( ! function_exists('simple_cms_core_backend_setting_social_instagram_to_contact_information') )
{
    function simple_cms_core_backend_setting_social_instagram_to_contact_information()
    {
        $value = simple_cms_setting('site_social_instagram', '');
        echo '<div class="form-group">
                    <label for="setting-site_social_instagram">Instagram</label>
                    <input id="setting-site_social_instagram" class="form-control form-control-sm" placeholder="Url Instagram" name="settings[site_social_instagram]" type="text" value="'.$value.'">
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_contact_information_right_add_action', 'simple_cms_core_backend_setting_social_instagram_to_contact_information');

/** LinkedIn **/
if ( ! function_exists('simple_cms_core_backend_setting_social_linkedin_to_contact_information') )
{
    function simple_cms_core_backend_setting_social_linkedin_to_contact_information()
    {
        $value = simple_cms_setting('site_social_linkedin', '');
        echo '<div class="form-group">
                    <label for="setting-site_social_linkedin">LinkedIn</label>
                    <input id="setting-site_social_linkedin" class="form-control form-control-sm" placeholder="Url LinkedIn" name="settings[site_social_linkedin]" type="text" value="'.$value.'">
                </div>';
    }
}
add_action('simple_cms_core_backend_setting_in_contact_information_right_add_action', 'simple_cms_core_backend_setting_social_linkedin_to_contact_information');

