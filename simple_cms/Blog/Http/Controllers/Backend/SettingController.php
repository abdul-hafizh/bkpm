<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('blog::setting.index');
    }

}
