<?php

namespace SimpleCMS\Slider\Http\Controllers\Backend;

use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Slider\Models\SliderModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Slider\Http\Requests\SliderCreateUpdateRequest;
use SimpleCMS\Slider\Services\SliderService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $params['sliders'] = SliderModel::orderBy('position','ASC')->withTrashed()->get();
        return view('slider::backend.index')->with($params);
    }

    public function add(Request $request)
    {
        $params['sliders'] = new SliderModel();
        $params['title'] = "New Slider";
        return view('slider::backend.add_edit')->with($params);
    }

    public function edit(Request $request,$id,$slug)
    {
        $id = encrypt_decrypt($id, 2);
        $params['sliders'] = SliderModel::where(['id'=>$id])->first();
        $params['title'] = "Edit Slider";
        return view('slider::backend.add_edit')->with($params);
    }

    public function save_update(SliderCreateUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess(SliderService::save_update($request));
        }
        throw new NotFoundHttpException(__('Not Found'));
    }

    public function restore_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(SliderService::restore_delete($request));
        }
        throw new NotFoundHttpException(__('Not Found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(SliderService::soft_delete($request));
        }
        throw new NotFoundHttpException(__('Not Found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(SliderService::force_delete($request));
        }
        throw new NotFoundHttpException(__('Not Found'));
    }
}
