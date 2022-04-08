<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 03 June 2020 14.13 ---------
 */

if ( ! function_exists('blog_grafik_default') )
{
    function blog_grafik_default()
    {
        /*if (auth()->check()) {
            $user = auth()->user();
            $params = [
                'countUsers' => 0,
                'countPosts' => 0,
                'countPages' => 0
            ];
            if (auth()->user()->group_id <= 2) {
                $params['countUsers'] = \SimpleCMS\ACL\Models\User::where('id', '>', 1)->count();
                $params['countPosts'] = \SimpleCMS\Blog\Models\PostModel::where('type', '=', 'post')->count();
                $params['countPages'] = \SimpleCMS\Blog\Models\PostModel::where('type', '=', 'page')->count();
            }else{
                $params['countPosts'] = \SimpleCMS\Blog\Models\PostModel::where('type', '=', 'post')->where('user_id', $user->id)->count();
                $params['countPages'] = \SimpleCMS\Blog\Models\PostModel::where('type', '=', 'page')->where('user_id', $user->id)->count();
            }
            echo view('blog::dashboard.index')->with($params)->render();
        }*/
    }
}

add_action('simple_cms_dashboard_backend_add_action', 'blog_grafik_default');
