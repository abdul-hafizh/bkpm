<?php

namespace SimpleCMS\Widget\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Widget\Services\WidgetService;

class WidgetController extends Controller
{

    /**
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        generate_widget_registered();
        return view('widget::backend.index');
    }

    /**
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function save(Request $request)
    {
        return responseSuccess(WidgetService::save($request));
    }

    /**
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function delete(Request $request)
    {
        return responseSuccess(WidgetService::delete($request));
    }

}
