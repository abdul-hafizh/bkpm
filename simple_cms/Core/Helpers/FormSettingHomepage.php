<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/20/20, 6:14 AM ---------
 */

/*
 * Function
 * - options_homepage
 * - simple_cms_core_backend_setting_homepage_to_homepage
 *
 * Hook filter
 * - simple_cms_core_backend_setting_options_homepage_add_filter
 * */
/** Option Homepage **/
if ( ! function_exists('options_homepage') )
{
    /**
     * @return array
    */
    function options_homepage()
    {
        $getHookOptionHomepage = apply_filter('simple_cms_core_backend_setting_options_homepage_add_filter');
        $default_setting = [
            [
                'id'        => 'page_login',
                'title'     => 'Page Login',
                'type'      => 'redirect',
                'value'     => route('simple_cms.acl.auth.login')
            ],
            [
                'id'        => 'default',
                'title'     => 'Page Default',
                'type'      => 'default',
                'value'     => 'index'
            ]
        ];

        if (app('modules')->has('Blog')) {
            array_push($default_setting, [
                'id'        => 'all_post',
                'title'     => 'All Post',
                'type'      => 'all_post',
                'value'     => 'all_post'
            ]);
            $getPages = post_query()->where(['posts.type' => 'page', 'posts.status' => 'publish'])->orderBy('posts.created_at', 'DESC')->cursor();
            foreach ($getPages as $page) {
                array_push($default_setting, [
                    'id' => $page->id,
                    'title' => 'Page: ' . $page->title,
                    'type' => 'page',
                    'value' => $page->id
                ]);
            }
        }
        if (is_array($getHookOptionHomepage)) {
            $default_setting = array_merge($default_setting, $getHookOptionHomepage);
        }
        return $default_setting;
    }
}
if ( ! function_exists('simple_cms_core_backend_setting_homepage_to_homepage') )
{

    function simple_cms_core_backend_setting_homepage_to_homepage()
    {
        $value = simple_cms_setting('homepage', 'page_login');
        $options_homepage = options_homepage();
        $html = '<div class="form-group">
                    <label for="setting-homepage">Homepage</label>
                    <select id="setting-homepage" class="form-control form-control-sm" name="settings[homepage]">';
                        foreach ($options_homepage as $homepage) {
                            $html .= '<option value="'. $homepage['id'] .'" '.($value==$homepage['id'] ? 'selected':'').'>'. $homepage['title'] .'</option>';
                        }
        $html .=    '</select>
                </div>';
        echo $html;
    }
}
add_action('simple_cms_core_backend_setting_in_homepage_left_add_action', 'simple_cms_core_backend_setting_homepage_to_homepage');
