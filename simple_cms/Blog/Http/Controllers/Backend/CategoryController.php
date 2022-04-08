<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SimpleCMS\Blog\DataTables\CategoryDataTable;
use SimpleCMS\Blog\Http\Requests\CategorySaveUpdateRequest;
use SimpleCMS\Blog\Models\CategoryModel;
use SimpleCMS\Blog\Services\CategoryService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('blog::category.backend.index');
    }

    public function add(Request $request)
    {
        $params['type']         = ($request->get('type') && !empty(filter($request->get('type'))) ? filter($request->get('type')) : 'post' );
        $params['category']     = new CategoryModel();
        $params['categories']   = CategoryModel::where('type', '=', $params['type'])->orderBy('name')->cursor();
        $params['title']        = 'Add';
        return view('blog::category.backend.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['type']         = ($request->get('type') && !empty(filter($request->get('type'))) ? filter($request->get('type')) : 'post' );
        $params['category'] = CategoryModel::where('id', $id)->where('type', '=', $params['type'])->first();
        if (!$params['category']){
            abort(404);
        }
        $params['categories']   = CategoryModel::where('id', '<>', $id)->where('type', '=', $params['type'])->orderBy('name')->cursor();
        $params['title']        = 'Edit';
        return view('blog::category.backend.add_edit')->with($params);
    }

    public function save_update(CategorySaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess(CategoryService::save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(CategoryService::restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(CategoryService::soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(CategoryService::force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

}
