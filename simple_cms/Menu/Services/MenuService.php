<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/20/20, 9:59 PM ---------
 */

namespace SimpleCMS\Menu\Services;


use SimpleCMS\Menu\Models\MenuModel;

class MenuService
{

    public static function save_update($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $old_menu = [];
        $logProperties = [
            'attributes' => [],
            'old' => ($id ? MenuModel::where('id', $id)->first()->toArray(): [])
        ];
        $slug = \Str::slug(filter($request->input('name')),'-');
        $whereUpdate = ['id' => $id, 'slug' => $slug];
        $menu = MenuModel::query()->updateOrCreate($whereUpdate,[
            'slug'=>$slug,
            'name' => filter($request->input('name')),
            'option' => json_encode($request->input('option'))
        ]);
        $logProperties['attributes'] = $menu->toArray();
        $message = 'Your '.($id ? 'edit' : 'add').' menu '.$menu->name;
        $activity_group = 'add';
        if (!empty($id)){
            $activity_group = 'edit';
        }
        activity_log(LOG_MENU, $activity_group, $message, $logProperties, $menu);
        if (count($logProperties['old'])){
            clearCacheMenu($logProperties['old']['slug']);
        }
        return responseMessage($message . ' success', ['redirect' => route('simple_cms.menu.backend.edit', ['id' => encrypt_decrypt($menu->id), 'slug' => $menu->slug]), 'old_menu' => $logProperties['old']]);
    }

    public static function restore_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                $menu = MenuModel::withTrashed()->where('id',$id)->restore();
            }
            return responseMessage(__('Menu '.$menu->name.' restored.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function soft_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                $menu = MenuModel::where('id', $id);
                $get_menu = $menu;
                $get_menu = $get_menu->first();
                clearCacheMenu($get_menu->slug);
                $menu_name = $get_menu->name;
                $menu->forceDelete();
            }
            return responseMessage(__('Menu '.$menu_name.' trashed.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function force_delete($request)
    {
        try{
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            if(!empty($id)) {
                $menu = MenuModel::where('id', $id);
                $get_menu = $menu;
                $get_menu = $get_menu->first();
                clearCacheMenu($get_menu->slug);
                $menu_name = $get_menu->name;
                $menu->forceDelete();
            }
            return responseMessage(__('Menu '.$menu_name.' deleted.'));
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function build_menu($menu_slug)
    {
        $menu_collections = getCacheMenu($menu_slug);
        $menu_collections = $menu_collections['option'];
        if(!\Menu::has(MENU_FRONTEND)){
            \Menu::create(MENU_FRONTEND, function($menu) {
                $menu->enableOrdering();
            });
        }
        self::generate_menu($menu_collections);
    }
    public static function generate_menu($menu_collections, $instance = null)
    {
        $locale = request()->session()->get('simple_cms.translation.locale');

        if(is_null($instance)){
            $menu = \Menu::instance(MENU_FRONTEND);
        }else{
            $menu = $instance;
        }

        foreach($menu_collections as $order => $menu_collect){
            if(isset($menu_collect['children']) && count($menu_collect['children'])){
                $menu->dropdown( (isset($menu_collect['label'][$locale]) ? $menu_collect['label'][$locale] : $menu_collect['label']), function ($sub) use($menu_collect) {
                    self::generate_menu($menu_collect['children'], $sub);
                },[
                    'key'           =>  $menu_collect['id'],
                    'url'           =>  $menu_collect['url'],
//                    'title'         =>  $menu_collect['label'],
                    'icon'      =>  $menu_collect['icon'],
                    'class'     =>  (!is_null($menu_collect['classcss']) ? $menu_collect['classcss'] : ''),
                    'title'     =>  ( !empty($menu_collect['title']) ? (isset($menu_collect['title'][$locale]) ? $menu_collect['title'][$locale] : $menu_collect['title']) : (isset($menu_collect['label'][$locale]) ? $menu_collect['label'][$locale] : $menu_collect['label'])),
                    'target'      =>  $menu_collect['target']
                ])->hideWhen(function() use($menu_collect){
                    return ((int)$menu_collect['status'] !== 1);
                })->order($order);
            }else{
                $menu->add([
                    'key'           =>  $menu_collect['id'],
                    'url'           =>  $menu_collect['url'],
                    'title'         =>  (isset($menu_collect['label'][$locale]) ? $menu_collect['label'][$locale] : $menu_collect['label']),
                    'attributes'    =>  [
                        'icon'      =>  $menu_collect['icon'],
                        'class'     =>  (!is_null($menu_collect['classcss']) ? $menu_collect['classcss'] : ''),
                        'title'     =>  ( !empty($menu_collect['title']) ? (isset($menu_collect['title'][$locale]) ? $menu_collect['title'][$locale] : $menu_collect['title']) : (isset($menu_collect['label'][$locale]) ? $menu_collect['label'][$locale] : $menu_collect['label'])),
                        'target'      =>  $menu_collect['target']
                    ]
                ])->hideWhen(function() use($menu_collect){
                    return ((int)$menu_collect['status'] !== 1);
                })->order($order);
            }
        }
    }
}
