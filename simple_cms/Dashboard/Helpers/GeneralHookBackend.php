<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 6:52 PM ---------
 */

/**
** Hook action constant function **
- simple_cms_dashboard_backend_hook

** Hook available **
* Hook Action
- simple_cms_dashboard_backend_add_action


* Hook Filter

* functions

*/
if ( ! function_exists('simple_cms_dashboard_backend_hook') )
{
    /**
     * @return mixed
     */
    function simple_cms_dashboard_backend_hook()
    {
        return do_action('simple_cms_dashboard_backend_add_action');
    }
}
