<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/19/20, 3:33 AM ---------
 */

namespace SimpleCMS\Plugin\Http\Controllers\Backend;

use Illuminate\Http\Request;
use SimpleCMS\Core\Http\Controllers\Controller;

class PluginController extends Controller
{
    public function index(Request $request)
    {
        $params['plugins'] = app('plugins')->getPlugins();
        return view('plugin::backend.index')->with($params);
    }

    public function change_status(Request $request, $slug, $status)
    {
        $plugin = app('plugins')->getBySlug($slug);
        if ($plugin === false){
            return responseError(responseMessage('Plugin not found/not installed.'));
        }
        $plugin->{$status}();
        $css_class = ($status == 'enable' ? 'text-info' : 'text-warning');
        return responseSuccess(responseMessage('Plugin &nbsp;<strong>' . $plugin->getName() . '</strong>&nbsp; <span class="'.$css_class.'">' . ucwords($status) .'d</span>'));
    }

    public function setting(Request $request, $slug)
    {
        return '';
    }
}
