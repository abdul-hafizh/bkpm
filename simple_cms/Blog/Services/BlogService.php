<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 09/05/18
 * Time: 1:42
 */

namespace SimpleCMS\Blog\Services;

use SimpleCMS\Blog\Models\CategoryModel;
use SimpleCMS\Blog\Models\PostModel;
use SimpleCMS\Core\Services\CoreService;
use SimpleCMS\Blog\Models\TagModel;
use Theme;

class BlogService
{

    public static function home()
    {
        try{
            seo_helper()->setTitle("HOME", site_name())->setDescription(site_description());
            return \Theme::view('index');
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function posts()
    {
        return app('post')->load();
    }

}
