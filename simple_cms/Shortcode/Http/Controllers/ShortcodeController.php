<?php

namespace SimpleCMS\Shortcode\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;

class ShortcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('shortcode::index');
    }
}
