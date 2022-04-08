<?php

namespace SimpleCMS\Wilayah\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Wilayah\Services\WilayahService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WilayahController extends Controller
{

    public function get_ajax(Request $request)
    {
        if($request->ajax()){
            return WilayahService::get_ajax($request);
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
}
