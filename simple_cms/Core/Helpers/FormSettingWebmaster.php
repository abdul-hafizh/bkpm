<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/7/20, 6:01 PM ---------
 */

/**
 *
 * Hook filter
 * - simple_cms_core_backend_setting_in_webmaster_add_filter
 * - simple_cms_core_backend_setting_in_webmaster_left_add_filter
 * - simple_cms_core_backend_setting_in_webmaster_right_add_filter
 *
 * Function add to hook action
 * - simple_cms_core_backend_setting_tab_webmaster
 * - simple_cms_core_backend_setting_tab_content_webmaster
 *
 * Function add to hook filter
 * - simple_cms_core_backend_setting_google_webmaster_to_webmaster
 * - simple_cms_core_backend_setting_bing_webmaster_to_webmaster
 * - simple_cms_core_backend_setting_alexa_webmaster_to_webmaster
 * - simple_cms_core_backend_setting_pinterest_webmaster_to_webmaster
 * - simple_cms_core_backend_setting_yandex_webmaster_to_webmaster
 * - simple_cms_core_backend_setting_google_analytic_to_webmaster
 *
**/

/* Tab Webmaster add to core tab setting action */
if ( ! function_exists('simple_cms_core_backend_setting_tab_webmaster') )
{
    function simple_cms_core_backend_setting_tab_webmaster()
    {
        echo '<a class="nav-link" id="vert-tabs-webmasters-tab" data-toggle="pill" href="#vert-tabs-webmasters" role="tab" aria-controls="vert-tabs-webmasters" aria-selected="false">Webmasters</a>';
    }
}
add_action('simple_cms_core_backend_setting_tab_add_action', 'simple_cms_core_backend_setting_tab_webmaster');

/* Tab Content Webmaster add to core tab content setting action */
if (!function_exists('simple_cms_core_backend_setting_tab_content_webmaster'))
{
    function simple_cms_core_backend_setting_tab_content_webmaster()
    {
        $url = route('simple_cms.setting.backend.save_update');
        $webmaster_both = apply_filter('simple_cms_core_backend_setting_in_webmaster_add_filter');
        if (is_array($webmaster_both)){
            $webmaster_both = implode('', $webmaster_both);
        }
        $webmaster_left = apply_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter');
        if (is_array($webmaster_left)){
            $webmaster_left = implode('', $webmaster_left);
        }
        $webmaster_right = apply_filter('simple_cms_core_backend_setting_in_webmaster_right_add_filter');
        if (is_array($webmaster_right)){
            $webmaster_right = implode('', $webmaster_right);
        }

        $html = '<div class="tab-pane fade" id="vert-tabs-webmasters" role="tabpanel" aria-labelledby="vert-tabs-webmasters-tab">';
        $html .= '<form class="formSettingSaveUpdate row" data-action="'.$url.'">';
        $html .= '<div class="col-md-6">' . $webmaster_left . '</div>';
        $html .= '<div class="col-md-6">' . $webmaster_right . ' </div>';
        $html .= $webmaster_both;
        $html .= '<div class="col-md-12 m-t-10">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary" title="Save"><i class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>';
        echo $html;
    }
}
add_action('simple_cms_core_backend_setting_tab_content_add_action', 'simple_cms_core_backend_setting_tab_content_webmaster');

/* INPUT SETTING WEBMASTER */
/** Webmaster Google **/
if ( ! function_exists('simple_cms_core_backend_setting_google_webmaster_to_webmaster') )
{
    function simple_cms_core_backend_setting_google_webmaster_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('webmaster_google', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_webmaster_google">Webmaster Google</label>
                    <input id="setting-input_setting_webmaster_google" class="form-control form-control-sm" placeholder="Webmaster Google" name="settings[webmaster_google]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter', 'simple_cms_core_backend_setting_google_webmaster_to_webmaster');

/** Webmaster Bing **/
if ( ! function_exists('simple_cms_core_backend_setting_bing_webmaster_to_webmaster') )
{
    function simple_cms_core_backend_setting_bing_webmaster_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('webmaster_bing', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_webmaster_bing">Webmaster Bing</label>
                    <input id="setting-input_setting_webmaster_bing" class="form-control form-control-sm" placeholder="Webmaster Bing" name="settings[webmaster_bing]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter', 'simple_cms_core_backend_setting_bing_webmaster_to_webmaster');

/** Webmaster Alexa **/
if ( ! function_exists('simple_cms_core_backend_setting_alexa_webmaster_to_webmaster') )
{
    function simple_cms_core_backend_setting_alexa_webmaster_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('webmaster_alexa', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_webmaster_alexa">Webmaster Alexa</label>
                    <input id="setting-input_setting_webmaster_alexa" class="form-control form-control-sm" placeholder="Webmaster Alexa" name="settings[webmaster_alexa]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter', 'simple_cms_core_backend_setting_alexa_webmaster_to_webmaster', 22);

/** Webmaster Pinterest **/
if ( ! function_exists('simple_cms_core_backend_setting_pinterest_webmaster_to_webmaster') )
{
    function simple_cms_core_backend_setting_pinterest_webmaster_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('webmaster_pinterest', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_webmaster_pinterest">Webmaster Pinterest</label>
                    <input id="setting-input_setting_webmaster_pinterest" class="form-control form-control-sm" placeholder="Webmaster Pinterest" name="settings[webmaster_pinterest]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter', 'simple_cms_core_backend_setting_pinterest_webmaster_to_webmaster', 22);

/** Webmaster Yandex **/
if ( ! function_exists('simple_cms_core_backend_setting_yandex_webmaster_to_webmaster') )
{
    function simple_cms_core_backend_setting_yandex_webmaster_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('webmaster_yandex', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_webmaster_yandex">Webmaster Yandex</label>
                    <input id="setting-input_setting_webmaster_yandex" class="form-control form-control-sm" placeholder="Webmaster Yandex" name="settings[webmaster_yandex]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_left_add_filter', 'simple_cms_core_backend_setting_yandex_webmaster_to_webmaster', 22);

/** Google Analytic **/
if ( ! function_exists('simple_cms_core_backend_setting_google_analytic_to_webmaster') )
{
    function simple_cms_core_backend_setting_google_analytic_to_webmaster($input_setting)
    {
        if (is_array($input_setting)){
            $input_setting = implode('', $input_setting);
        }
        $value = simple_cms_setting('site_g_analytic', '');
        return $input_setting . '<div class="form-group">
                    <label for="setting-input_setting_site_google_analytic">Google Analytic</label>
                    <input id="setting-input_setting_site_google_analytic" class="form-control form-control-sm" placeholder="eg: UA-XXXXXXXX-X" name="settings[site_g_analytic]" type="text" value="'.$value.'">
                </div>';
    }
}
add_filter('simple_cms_core_backend_setting_in_webmaster_right_add_filter', 'simple_cms_core_backend_setting_google_analytic_to_webmaster', 22);

