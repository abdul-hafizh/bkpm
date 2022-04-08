<?php

namespace SimpleCMS\Blog\Http\Controllers\Backend;

use SimpleCMS\ACL\Models\User;
use SimpleCMS\Blog\DataTables\PostDataTable;
use SimpleCMS\Blog\Services\BlogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
//use SimpleCMS\Blog\DataTables\Posts\ListPostsDT;
use SimpleCMS\Blog\Http\Requests\PostSaveUpdateRequest;
use SimpleCMS\Blog\Models\CategoryModel;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Blog\Models\TagModel;
use SimpleCMS\Blog\Services\CategoryService;
use SimpleCMS\Blog\Services\PostsService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function index(PostDataTable $postDataTable)
    {
        return $postDataTable->render('blog::post.backend.index');
    }

    public function preview(Request $request,$post_slug='')
    {
        return BlogService::posts();
    }

    public function add_edit(Request $request,$post_slug='')
    {
        $params['post_type'] = 'post';
        $params['post_slug'] = $post_slug;
        $params['post'] = new PostModel();
        $params['hasCategories'] = [];
        $params['title'] = "Add New Post";
        if($post_slug){
            $params['post'] = PostModel::where(['type'=>$params['post_type'],'slug'=>$post_slug])->with('categories')->first();
            /*$params['hasCategories'] = array_map(function ($q){
                return $q->id;
            },$params['post']->categories->cursor());*/
            $params['hasCategories'] = $params['post']->categories()->cursor()->map(function($q){
               return $q->id;
            });
            $params['title'] = "Edit Post";
        }
        $params['authors'] = User::canPost()->cursor();
        $params['categories'] = CategoryService::jquery_treevew($params['post_type']);
        return view('blog::post.backend.add_edit')->with($params);
    }

    public function save_update(PostSaveUpdateRequest $request)
    {
        if($request->ajax()){
            if ($request->get('change_status') && trim($request->get('change_status'))!='')
            {
                return responseSuccess(PostsService::change_status($request));
            }
            return responseSuccess(PostsService::save_update($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PostsService::restore($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PostsService::soft_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PostsService::force_delete($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function active_inactive_comment(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PostsService::active_inactive_comment($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

    public function active_inactive_featured(Request $request)
    {
        if($request->ajax()){
            return responseSuccess(PostsService::active_inactive_featured($request));
        }
        throw new NotFoundHttpException(__('core::message.error.not_found'));
    }

}
