<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/28/20, 7:41 AM ---------
 */

namespace SimpleCMS\Dashboard\Http\Controllers\Backend;

use Illuminate\Http\Request;
use SimpleCMS\Core\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard::backend.index');
    }
}
