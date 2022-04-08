<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/20/20, 6:14 AM ---------
 */

if ( ! function_exists('simple_cms_blog_backend_setting_paginates_to_general') )
{
    function simple_cms_blog_backend_setting_paginates_to_general()
    {
        $paginate_archive = simple_cms_setting('paginate_archive', 6);
        $paginate_category = simple_cms_setting('paginate_category', 6);
        $paginate_post = simple_cms_setting('paginate_post', 6);
        $paginate_tag = simple_cms_setting('paginate_tag', 6);
        $paginate_search = simple_cms_setting('paginate_search', 6);
        $html = '<div class="form-group">
                    <label for="setting-paginate_archive">Limit/Paginate Archive <strong class="text-danger">*</strong></label>
                    <input id="setting-paginate_archive" type="number" name="settings[paginate_archive]" value="'.$paginate_archive.'" data-counter="100" placeholder="eg: 6" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="setting-paginate_category">Limit/Paginate Category <strong class="text-danger">*</strong></label>
                    <input id="setting-paginate_category" type="number" name="settings[paginate_category]" value="'.$paginate_category.'" data-counter="100" placeholder="eg: 6" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="setting-paginate_post">Limit/Paginate Post <strong class="text-danger">*</strong></label>
                    <input id="setting-paginate_post" type="number" name="settings[paginate_post]" value="'.$paginate_post.'" data-counter="100" placeholder="eg: 6" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="setting-paginate_tag">Limit/Paginate Tag <strong class="text-danger">*</strong></label>
                    <input id="setting-paginate_tag" type="number" name="settings[paginate_tag]" value="'.$paginate_tag.'" data-counter="100" placeholder="eg: 6" class="form-control form-control-sm" required>
                </div>
                <div class="form-group">
                    <label for="setting-paginate_search">Limit/Paginate Search <strong class="text-danger">*</strong></label>
                    <input id="setting-paginate_search" type="number" name="settings[paginate_search]" value="'.$paginate_search.'" data-counter="100" placeholder="eg: 6" class="form-control form-control-sm" required>
                </div>';
        echo $html;
    }
}
add_action('simple_cms_blog_backend_setting_in_general_right_add_action', 'simple_cms_blog_backend_setting_paginates_to_general');

if ( ! function_exists('simple_cms_blog_backend_setting_type_post_url_to_general') )
{
    function simple_cms_blog_backend_setting_type_post_url_to_general()
    {
        $value = simple_cms_setting('type_post_url', 'default');
        echo '<div class="col-md-12">
                <div class="form-group">
                    <label>Permalink Post</label>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input id="settings_type_post_url_default" class="custom-control-input" type="radio" name="settings[type_post_url]" value="default" '.($value == 'default' ? 'checked':'').'>
                            <label for="settings_type_post_url_default" class="custom-control-label pointer-cursor">Default <code>'.route('simple_cms.blog.post', ['post_slug'=>'sample-post']).'</code></label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="settings_type_post_url_year_month" class="custom-control-input" type="radio" name="settings[type_post_url]" value="year_month" '.($value == 'year_month' ? 'checked':'').'>
                            <label for="settings_type_post_url_year_month" class="custom-control-label pointer-cursor">Year month <code>'.route('simple_cms.blog.post_archive', ['year'=>date('Y'), 'month'=>date('m'), 'post_slug'=>'sample-post']).'</code></label>
                        </div>
                    </div>
                </div>
            </div>';
    }
}
add_action('simple_cms_blog_backend_setting_in_general_add_action', 'simple_cms_blog_backend_setting_type_post_url_to_general');
