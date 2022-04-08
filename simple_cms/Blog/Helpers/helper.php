<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/11/20, 9:41 AM ---------
 */

define('LOG_TAG', 'LOG_TAG');
define('LOG_CATEGORY', 'LOG_CATEGORY');
define('LOG_POST', 'LOG_POST');
define('LOG_GALLERY', 'LOG_GALLERY');
define('LOG_PAGE', 'LOG_PAGE');

if ( ! function_exists('generateSlug'))
{
    function generateSlug($id, $slug, $original_slug = '')
    {
        return \SimpleCMS\Blog\Services\PostsService::generateSlug($id, $slug, $original_slug);
    }
}

if ( ! function_exists('post_query'))
{
    /**
    * @return \SimpleCMS\Blog\Models\PostModel
    */
    function post_query()
    {
        return \SimpleCMS\Blog\Models\PostModel::query();
    }
}

if ( ! function_exists('post_latest'))
{
    /**
     * @param integer $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    function post_latest($limit=6)
    {
        return post_query()
            ->whereIn('posts.type', app('config')->get('blog.type_post'))
            ->whereIn('posts.status', app('config')->get('blog.post_status'))
            ->orderBy('posts.created_at', 'DESC')->paginate($limit);
    }
}
if ( ! function_exists('thumb_image'))
{
    /**
     * @return string
     */
    function thumb_image()
    {
        return simple_cms_setting('thumbnail_default', module_asset('core', 'images/default-thumb.jpg'));
    }
}
