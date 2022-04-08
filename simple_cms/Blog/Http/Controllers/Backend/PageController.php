<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SimpleCMS\Blog\DataTables\PageDataTable;
use SimpleCMS\Blog\Http\Requests\PageSaveUpdateRequest;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Blog\Services\BlogService;
use SimpleCMS\Blog\Services\PagesService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageController extends Controller
{
    public function index(PageDataTable $pageDataTable)
    {
        return $pageDataTable->render('blog::page.backend.index');
    }

    public function preview(Request $request,$page_slug='')
    {
        return BlogService::posts();
    }

    public function add_edit(Request $request,$page_slug='')
    {
        $params['page_type'] = 'page';
        $params['page_slug'] = $page_slug;
        $params['page'] = new PostModel();
        $params['title'] = "Add New Page";
        if($page_slug){
            $params['page'] = PostModel::where(['type'=>$params['page_type'],'slug'=>$page_slug])->first();
            $params['title'] = "Edit Page";
        }
        return view('blog::page.backend.add_edit')->with($params);
    }

    public function save_update(PageSaveUpdateRequest $request)
    {
        if($request->ajax()){
            if ($request->get('change_status') && trim($request->get('change_status'))!='')
            {
                return responseSuccess(PagesService::change_status($request));
            }
            return responseSuccess(PagesService::save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PagesService::restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PagesService::soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PagesService::force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

}
