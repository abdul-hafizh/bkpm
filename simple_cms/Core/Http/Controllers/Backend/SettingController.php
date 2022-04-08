<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 2:59 PM ---------
 */

namespace SimpleCMS\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Core\Services\SettingService;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('core::setting.backend.index');
    }

    public function save_update(Request $request)
    {
        return responseSuccess(SettingService::save_update($request));
    }

    public function store_file(Request $request)
    {
        return responseSuccess(SettingService::store_file($request));
    }
}