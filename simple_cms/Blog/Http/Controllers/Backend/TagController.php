<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SimpleCMS\Blog\DataTables\TagDataTable;
use SimpleCMS\Blog\Http\Requests\TagSaveUpdateRequest;
use SimpleCMS\Blog\Models\TagModel;
use SimpleCMS\Blog\Services\TagsService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends Controller
{
    public function select2(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(TagsService::select2($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function index(TagDataTable $tagDataTable)
    {
        return $tagDataTable->render('blog::tag.backend.index');
    }

    public function modal_edd_edit(Request $request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        if($request->ajax()) {
            $params['tag'] = (!empty($id) OR !is_null($id) ? TagModel::where('id', '=', $id)->first() : new TagModel());
            return view('blog::tag.backend.modal.add_edit')->with($params);
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function save_update(TagSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess(TagsService::save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(TagsService::restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(TagsService::soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(TagsService::force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

}
