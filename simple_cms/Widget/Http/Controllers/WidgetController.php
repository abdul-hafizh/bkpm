<?php

namespace SimpleCMS\Widget\Http\Controllers;

use SimpleCMS\Widget\Factories\AbstractWidgetFactory;
use SimpleCMS\Widget\WidgetId;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;

class WidgetController extends Controller
{

    /**
     * The action to show widget output via ajax.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function showWidget(Request $request)
    {
        $this->prepareGlobals($request);

        $factory = app()->make('widget');
        $widgetName = $request->input('name', '');

        $widgetParams = $request->input('skip_encryption', '')
            ? $request->input('params', '')
            : $factory->decryptWidgetParams($request->input('params', ''));

        $decodedParams = json_decode($widgetParams, true);

        return call_user_func_array([$factory, $widgetName], $decodedParams ?: []);
    }

    /**
     * Set some specials variables to modify the workflow of the widget factory.
     *
     * @param Request $request
     */
    protected function prepareGlobals(Request $request)
    {
        WidgetId::set($request->input('id', 1) - 1);
        AbstractWidgetFactory::$skipWidgetContainer = true;
        if ($request->input('skip_encryption', '')) {
            AbstractWidgetFactory::$allowOnlyWidgetsWithDisabledEncryption = true;
        }
    }
}
