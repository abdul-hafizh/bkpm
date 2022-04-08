<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use SimpleCMS\Blog\DataTables\GalleryDataTable;
use SimpleCMS\Blog\Http\Requests\GallerySaveUpdateRequest;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Blog\Services\BlogService;
use SimpleCMS\Blog\Services\GalleryService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends Controller
{
    protected $galleryService;

    public function __construct()
    {
        $this->galleryService = app(GalleryService::class);
    }

    public function index(GalleryDataTable $pageDataTable)
    {
        $params['title'] = trans('label.gallery');
        return $pageDataTable->render('blog::gallery.backend.index', $params);
    }

    public function preview(Request $request,$page_slug='')
    {
        return BlogService::posts();
    }

    public function add_edit(Request $request,$page_slug='')
    {
        $params['page_type'] = 'gallery';
        $params['page_slug'] = $page_slug;
        $params['page'] = new PostModel();
        $params['title'] = trans('label.gallery_add');
        if($page_slug){
            $params['page'] = PostModel::where(['type'=>$params['page_type'],'slug'=>$page_slug])->first();
            $params['title'] = trans('label.gallery_edit');
        }
        return view('blog::gallery.backend.add_edit')->with($params);
    }

    public function save_update(GallerySaveUpdateRequest $request)
    {
        if($request->ajax()){
            if ($request->get('change_status') && trim($request->get('change_status'))!='')
            {
                return responseSuccess($this->galleryService->change_status($request));
            }
            return responseSuccess($this->galleryService->save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->galleryService->restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->galleryService->soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->galleryService->force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

}
