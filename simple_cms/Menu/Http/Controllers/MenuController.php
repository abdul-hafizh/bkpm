<?php

namespace SimpleCMS\Menu\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Blog\Services\TagsService;
use SimpleCMS\Menu\Http\Requests\MenuSaveUpdateRequest;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Blog\Services\CategoryService;
use SimpleCMS\Core\Http\Controllers\Controller;
use SimpleCMS\Menu\DataTables\MenuDataTable;
use SimpleCMS\Menu\Models\MenuModel;
use SimpleCMS\Menu\Services\MenuService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MenuController extends Controller
{

    public function index(MenuDataTable $menuDataTable)
    {
        return $menuDataTable->render('menu::backend.index');
    }

    public function add(Request $request)
    {
        $params['menu'] = new MenuModel();
        $params['title'] = 'Add Menu';
        $params['categories'] = CategoryService::tpl_checkbox_menu();
        $params['tags'] = TagsService::tpl_checkbox_menu();
        $params['nestable_menu'] =  [];
        $params['pages'] = PostModel::whereIn('posts.type', config('blog.type_page'))->whereIn('posts.status',['publish','member'])->cursor();
        return view('menu::backend.add_edit')->with($params);
    }

    public function edit(Request $request, $id, $slug)
    {
        $id = encrypt_decrypt($id, 2);
        $params['menu'] = MenuModel::where(['id' => $id, 'slug' => filter($slug)])->first();
        if (!$params['menu']){
            throw new NotFoundHttpException('Not Found');
        }
        $params['title'] = 'Edit Menu';
        $params['categories'] = CategoryService::tpl_checkbox_menu();
        $params['tags'] = TagsService::tpl_checkbox_menu();
        $params['nestable_menu'] =  json_decode($params['menu']->option);
        $params['pages'] = PostModel::whereIn('posts.type', config('blog.type_page'))->whereIn('posts.status',['publish','member'])->cursor();
        return view('menu::backend.add_edit')->with($params);
    }

    public function save_update(MenuSaveUpdateRequest $request)
    {
        return responseSuccess(MenuService::save_update($request));
    }

    public function soft_delete(Request $request)
    {
        return responseSuccess(MenuService::soft_delete($request));
    }

    public function force_delete(Request $request)
    {
        return responseSuccess(MenuService::force_delete($request));
    }

    public function restore(Request $request)
    {
        return responseSuccess(MenuService::restore($request));
    }

}
