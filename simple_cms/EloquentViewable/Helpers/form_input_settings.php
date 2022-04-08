<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/9/20, 1:53 PM ---------
 */


if ( ! function_exists('input_setting_eloquentviewable_ignored_ip_addresses') )
{
    function input_setting_eloquentviewable_ignored_ip_addresses()
    {
        $value = simple_cms_setting('eloquentviewable_ignored_ip_addresses');
        $listIpToArray = explode(',', $value);
        $your_ip = request()->ip();
        $message = '<span class="text-success">Your current IP address is not blocked [<code>'.$your_ip.'</code>]</span>';
        if (in_array($your_ip, $listIpToArray)){
            $message = '<span class="text-danger">Your current IP address is blocked [<code>'.$your_ip.'</code>]</span>';
        }
        echo '<div class="col-md-12">
                <div class="form-group">
                    <label>IP addresses are ignored when viewing posts</label>
                    <br/>
                    '. $message .'
                    <input id="setting-eloquentviewable_ignored_ip_addresses" type="text" name="settings[eloquentviewable_ignored_ip_addresses]" value="'.$value.'" data-counter="100" placeholder="eg: 127.0.0.1,188.88.8.1" class="form-control form-control-sm">
                    <span class="">Please separate them with commas [<code class="text-bold">,</code>] if more than one</span>
                </div>
            </div>';
    }
}
add_action('simple_cms_blog_backend_setting_in_general_add_action', 'input_setting_eloquentviewable_ignored_ip_addresses');
