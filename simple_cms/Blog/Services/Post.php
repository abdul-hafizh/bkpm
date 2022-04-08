<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/5/20, 7:38 PM ---------
 */

namespace SimpleCMS\Blog\Services;

use SimpleCMS\Blog\Contracts\Post as PostContract;
use Illuminate\Http\Request;
use SimpleCMS\Theme\Theme;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\View\Factory as ViewFactory;

class Post implements PostContract
{
    /**
     * @var \Illuminate\Http\Request
     * */
    protected $request;

    /**
     * @var \SimpleCMS\Blog\Models\PostModel
     * */
    protected $model;

    /**
     * @var \SimpleCMS\Theme\Theme
     * */
    protected $theme;

    /**
     * Repository config.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var  \Illuminate\View\Factory
     * */
    protected $view;

    /**
     * @var  string
     * */
    protected $post_title, $post_slug, $post_type, $post_year, $post_month, $post_search;

    /**
     * @var  integer
     * */
    protected $paginate_archive, $paginate_post, $paginate_category, $paginate_tag, $paginate_search;

    /**
     * @var  array
     * */
    protected $post_status = ['publish', 'member'];

    /**
     * @var  object
     * */
    protected $category, $tag;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Config\Repository $config
     * @param \Illuminate\View\Factory $view
     * @param \SimpleCMS\Theme\Theme $theme
     *
     * @return \SimpleCMS\Blog\Services\Post
    */
    public function __construct(Request $request, ConfigRepository $config, ViewFactory $view, Theme $theme)
    {
        $this->request  = $request;
        $this->model    = \SimpleCMS\Blog\Models\PostModel::query();
        $this->theme = $theme;
        $this->config  = $config;
        $this->view  = $view;

        $this->post_status = $this->config->get('blog.post_status');

        $this->post_slug = filter($this->request->route()->parameter('post_slug'));
        $this->post_year = filter($this->request->route()->parameter('year'));
        $this->post_month = filter($this->request->route()->parameter('month'));
        $this->post_search = filter($this->request->get('search'));//filter($this->request->route()->parameter('search'));

        $this->paginate_archive = (int) simple_cms_setting('paginate_archive', 6);
        $this->paginate_post = (int) simple_cms_setting('paginate_post', 6);
        $this->paginate_category = (int) simple_cms_setting('paginate_category', 6);
        $this->paginate_tag = (int) simple_cms_setting('paginate_tag', 6);
        $this->paginate_search = (int) simple_cms_setting('paginate_search', 6);
    }

    protected function query()
    {
        return \SimpleCMS\Blog\Models\PostModel::select('*');
    }

    public function getPost()
    {
        return \SimpleCMS\Blog\Models\PostModel::whereIn('posts.type', $this->config->get('blog.type_post'))->whereIn('posts.status', $this->post_status);
    }

    protected function archives()
    {
        $this->post_type = 'archive';
        return $this->getPost()
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->whereYear('posts.created_at', $this->post_year)
            ->whereMonth('posts.created_at', $this->post_month)
            ->orderBy('posts.created_at', 'DESC')
            ->paginate($this->paginate_archive)->appends(request()->except(['page','_token']));
    }

    protected function category()
    {
        $this->category = \SimpleCMS\Blog\Models\CategoryModel::where('categories.slug', $this->post_slug)->first();
    }
    protected function categories()
    {
        $this->post_type = 'category';

        $this->category();

        return $this->getPost()
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->whereHas('categories',function ($q) {
                return $q->where('categories.slug',$this->post_slug);
            })
            ->orderBy('posts.created_at','DESC')
            ->paginate($this->paginate_category)->appends(request()->except(['page','_token']));
    }

    protected function tag()
    {
        $this->tag = \SimpleCMS\Blog\Models\TagModel::where('tags.slug', $this->post_slug)->first();
    }
    protected function tags()
    {
        $this->post_type = 'tag';

        $this->tag();

        return $this->getPost()
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->whereHas('tags',function ($q) {
                return $q->where('tags.slug',$this->post_slug);
            })
            ->orderBy('posts.created_at','DESC')
            ->paginate($this->paginate_tag)->appends(request()->except(['page','_token']));
    }

    protected function posts()
    {
        $this->post_type = 'posts';
        return $this->getPost()
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->orderBy('posts.created_at', 'DESC')
            ->paginate($this->paginate_post)->appends(request()->except(['page','_token']));
    }

    protected function gallery()
    {
        $this->post_type = 'gallery';
        return \SimpleCMS\Blog\Models\PostModel::whereIn('posts.status', $this->post_status)
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->where('posts.type', 'gallery')
            ->orderBy('posts.created_at', 'DESC')
            ->paginate($this->paginate_post)->appends(request()->except(['page','_token']));
    }

    protected function searchs()
    {
        $this->post_type = 'search';
        return $this->getPost()
            ->select(
                'posts.*',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where(function($q){
                if (!empty($this->post_search)) {
                    $q->where('posts.title', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('posts.description', 'LIKE', '%' . $this->post_search . '%')
                        ->orWhere('users.name', 'LIKE', '%' . $this->post_search . '%');
                }
            })
            ->orderBy('posts.created_at', 'DESC')
            ->paginate($this->paginate_search)->appends(request()->except(['page','_token']));
    }

    protected function post_archive()
    {
        $this->post_type = 'post_archive';
        return $this->getPost()
            ->where(['posts.slug' => $this->post_slug])
            ->whereYear('posts.created_at', $this->post_year)
            ->whereMonth('posts.created_at', $this->post_month)
            ->first();
    }

    protected function post()
    {
        return $this->query()->where(['posts.slug' => $this->post_slug])
            ->whereIn('posts.status', $this->post_status)
            ->first();
    }
    protected function setPostTitle($title)
    {
        return $title;
    }

    public function load()
    {
        $seo = seo_helper();
        $site_keyword = explode(',', site_keyword());
        $param['posts'] = false;
        $param['full_page'] = 0;
        $view = 'post';
        $title_combine = '';
        $thumb_default = thumb_image();
        $show_fancybox = true;
        switch ($this->request->route()->getName())
        {
            case 'simple_cms.blog.archive':
                $param['posts'] = $this->archives();
                $this->post_title = formatDate('01-'.$this->post_month.'-'.$this->post_year,0,0,1,1);
                $seo->setDescription(site_name() . ' - Archive ' . $this->post_title);
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.archive'),
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.archive', ['year'=>$this->post_year, 'month'=>$this->post_month]));
                $title_combine = trans('blog::frontend.label.archive').': ';
                break;
            case 'simple_cms.blog.category':
                $param['posts'] = $this->categories();
                $param['category'] = $this->category;
                if (!$this->category){
                    $this->post_title =  trans('core::message.error.not_found');
                    $seo->setDescription(site_name() . ' - ' . $this->post_title);
                }else{
                    $this->post_title =  trans($this->category->name);
                    $description = (!empty($this->category->description) ? trans($this->category->description) : trans('blog::frontend.label.category').' '.$this->post_title);
                    $seo->setDescription( site_name() . ' - ' . $description);
                    if (!empty($this->category->thumb_image)){
                        $thumb_default = str_replace(['http://', 'https://', '//'], 'https://', $this->category->thumb_image);
                    }
                }
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.category'),
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.category', ['post_slug'=>$this->post_slug]));
                $title_combine = trans('blog::frontend.label.category').': ';
                break;
            case 'simple_cms.blog.tag':
                $param['posts'] = $this->tags();
                if (!$this->tag){
                    $this->post_title =  trans('core::message.error.not_found');
                    $seo->setDescription(site_name() . ' - ' . $this->post_title);
                }else{
                    $this->post_title =  $this->tag->name;
                    $description = trans('blog::frontend.label.tag').' '.$this->post_title;
                    $seo->setDescription( site_name() . ' - ' . $description);
                }
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.tag'),
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.tag', ['post_slug'=>$this->post_slug]));
                $title_combine = trans('blog::frontend.label.tag').': ';
                break;
            case 'simple_cms.blog.search':
                $param['posts'] = $this->searchs();
                $this->post_title =  $this->post_search;
                $description = trans('blog::frontend.label.search').' '.$this->post_title;
                $param['search'] = $this->post_search;
                $seo->setDescription( site_name() . ' - ' . $description);
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.search'),
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.search', ['search'=>$this->post_search]));
                $title_combine = trans('blog::frontend.label.searching').': ';
                $view = 'search';
                if (!view()->exists('theme_active::views.search')){
                    $view = 'post';
                }
                break;
            case 'simple_cms.blog.post_archive':
                $param['posts'] = $this->post_archive();
                if (!$param['posts']){
                    $this->post_title =  trans('core::message.error.not_found');
                    $seo->setDescription(site_name() . ' - ' . $this->post_title);
                    $keyword = [
                        $this->post_title,
                        trans('blog::frontend.label.post'),
                        trans('blog::frontend.label.archive'),
                        trans('blog::frontend.label.blog')
                    ];
                    $keyword = array_unique(array_merge($keyword, $site_keyword));
                }else{
                    views($param['posts'])->cooldown(now()->addMinutes(3))->record();
                    $this->post_title =  trans($param['posts']->title);
                    $description = (!empty($param['posts']->description) ? trans($param['posts']->description) : $this->post_title);
                    $seo->setDescription( site_name() . ' - ' . $description );
                    $keyword = [];
                    foreach ($param['posts']->categories()->cursor() as $category) {
                        array_push($keyword, trans($category->name));
                        if ($category->parent){
                            array_push($keyword, trans($category->parent->name));
                        }
                    }
                    foreach ($param['posts']->tags()->cursor() as $tag) {
                        array_push($keyword, $tag->name);
                    }
                    if (!empty($param['posts']->thumb_image)){
                        $thumb_default = str_replace(['http://', 'https://', '//'], 'https://', $param['posts']->thumb_image);
                    }
                    $param['full_page'] = (int)$param['posts']->full_page;
                }
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.post_archive', ['year' => $this->post_year, 'month' =>$this->post_month, 'post_slug'=>$this->post_slug]));
                $view = 'post_single';
                break;
            case 'simple_cms.blog.galleries':
                $param['posts'] = $this->gallery();
                $title = trans('label.gallery');
                $this->post_title = $title;
                $description = $this->post_title;
                $seo->setDescription( site_name() . ' - ' . $description);
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.galleries'));
                $title_combine = '';
                $view = 'galleries';
                if (!view()->exists("theme_active::views.{$view}")){
                    $view = 'post';
                }
                break;
            case 'simple_cms.blog.post':
                $param['posts'] = $this->post();
                $view = 'post_single';
                if (!$param['posts']){
                    $this->post_title =  trans('core::message.error.not_found');
                    $seo->setDescription(site_name() . ' - ' . $this->post_title);
                    $keyword = [
                        $this->post_title
                    ];
                    $keyword = array_unique(array_merge($keyword, $site_keyword));
                }else{
                    views($param['posts'])->cooldown(now()->addMinutes(3))->record();
                    $this->post_title =  trans($param['posts']->title);
                    $description = (!empty($param['posts']->description) ? trans($param['posts']->description) : $this->post_title);
                    $seo->setDescription( site_name() . ' - ' . $description );
                    $keyword = [];
                    if ($param['posts']->type == 'page'){
                        $keyword = [
                            $this->post_title,
                            trans('blog::frontend.label.page'),
                            trans('blog::frontend.label.post'),
                            trans('blog::frontend.label.blog')
                        ];
                        $keyword = array_unique(array_merge($keyword, $site_keyword));
                        $view = 'page';
                    }elseif($param['posts']->type == 'gallery'){
                        $show_fancybox = false;
                        \Theme::asset()->container('head')->usePath(false)->add('blueimp-gallery.min.css', module_asset('core', 'plugins/blueimp/gallery/css/blueimp-gallery.min.css'));
                        \Theme::asset()->container('head')->usePath(false)->add('blueimp-gallery-indicator.css', module_asset('core', 'plugins/blueimp/gallery/css/blueimp-gallery-indicator.css'));
                        \Theme::asset()->container('head')->usePath(false)->add('blueimp-gallery-video.css', module_asset('core', 'plugins/blueimp/gallery/css/blueimp-gallery-video.css'));

                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-helper.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-helper.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery.min.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery.min.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery-fullscreen.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery-fullscreen.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery-indicator.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery-indicator.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery-video.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery-video.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery-vimeo.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery-vimeo.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('blueimp-gallery-youtube.js', module_asset('core', 'plugins/blueimp/gallery/js/blueimp-gallery-youtube.js'));
                        \Theme::asset()->container('footer')->usePath(false)->add('jquery.blueimp-gallery.js', module_asset('core', 'plugins/blueimp/gallery/js/jquery.blueimp-gallery.min.js'));

                        if ( file_exists(public_path('themes/'.themeActive().'/gallery/css/gallery.css')) ){
                            \Theme::asset()->container('head')->usePath()->add('simple-cms-gallery.css', 'gallery/css/gallery.css');
                        }else{
                            $gallery_css = module_asset('blog', 'gallery/frontend/css/simple-cms-gallery.css');
                            \Theme::asset()->container('head')->usePath(false)->add('simple-cms-gallery.css', $gallery_css);
                        }

                        if ( file_exists(public_path('themes/'.themeActive().'/gallery/js/gallery.js')) ){
                            \Theme::asset()->container('footer')->usePath()->add('simple-cms-gallery.js', 'gallery/js/gallery.js');
                        }else{
                            $gallery_js = module_asset('blog', 'gallery/frontend/js/simple-cms-gallery.js');
                            \Theme::asset()->container('footer')->usePath(false)->add('simple-cms-gallery.js', $gallery_js);
                        }

                        $keyword = [
                            $this->post_title,
                            trans('blog::frontend.label.page'),
                            trans('blog::frontend.label.post'),
                            trans('blog::frontend.label.blog')
                        ];
                        $keyword = array_unique(array_merge($keyword, $site_keyword));
                        $view = 'gallery';
                    }else {
                        foreach ($param['posts']->categories()->cursor() as $category) {
                            array_push($keyword, trans($category->name));
                            if ($category->parent) {
                                array_push($keyword, trans($category->parent->name));
                            }
                        }
                        foreach ($param['posts']->tags()->cursor() as $tag) {
                            array_push($keyword, $tag->name);
                        }
                    }
                    $param['full_page'] = (int)$param['posts']->full_page;
                    if (!empty($param['posts']->thumb_image)){
                        $thumb_default = str_replace(['http://', 'https://', '//'], 'https://', $param['posts']->thumb_image);
                    }

                }
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.post', ['post_slug'=>$this->post_slug]));

                if ($show_fancybox){
                    \Theme::asset()->container('footer')->writeScript('gallery-js', '$(document).ready(function () {
                            let imgToFancyBox = $(".simple-cms-post-content img");
                            if (imgToFancyBox.length) {
                                imgToFancyBox.addClass(\'cursor-pointer\').attr(\'title\', \'Click for zoom image.\');
                                imgToFancyBox.on(\'click\',function(e){
                                    e.stopPropagation();
                                    let self = $(this);
                                    $.colorbox({
                                        href: self.attr(\'src\'),
                                        transition : \'elastic\',
                                        scrolling: false
                                    });
                                })
                            }
                        });');
                }
                if (in_array($param['posts']->status, ['member']) && !auth()->check()){
                    return redirect()->route('simple_cms.acl.auth.login');
                }
                break;
            default:
                $param['posts'] = $this->posts();
                $this->post_title = trans('blog::frontend.label.all_post');
                $seo->setDescription(site_name() . ' - ' . $this->post_title);
                $keyword = [
                    $this->post_title,
                    trans('blog::frontend.label.post'),
                    trans('blog::frontend.label.blog')
                ];
                $keyword = array_unique(array_merge($keyword, $site_keyword));
                $seo->setKeywords($keyword);
                $seo->setImage($thumb_default);
                $seo->setUrl(route('simple_cms.blog.index'));
                break;
        }

        $seo->setTitle( $title_combine . $this->post_title);

        $param['post_title'] = $title_combine . $this->post_title;
        $param['post_type'] = $this->post_type;
        return \Theme::view($view, $param);
    }


    /**
     * Magic method for set, prepend, append, has, get.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters = array())
    {
        $callable = preg_split('|[A-Z]|', $method);

        if (in_array($callable[0], ['load', 'getPost'])) {
            $value = lcfirst(preg_replace('|^'.$callable[0].'|', '', $method));
            array_unshift($parameters, $value);

            return call_user_func_array(array($this, $callable[0]), $parameters);
        }

        trigger_error('Call to undefined method '.__CLASS__.'::'.$method.'()', E_USER_ERROR);
    }

}
