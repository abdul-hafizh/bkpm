<?php

namespace SimpleCMS\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleCMS\ACL\Models\User;
use SimpleCMS\EloquentViewable\Contracts\Viewable;
use SimpleCMS\EloquentViewable\InteractsWithViews;
use SimpleCMS\Translation\Traits\Translatable;

class PostModel extends Model implements Viewable
{
    use InteractsWithViews, SoftDeletes, Translatable;
    protected $translatableAttributes = ['title', 'content', 'description'];
    protected $table = 'posts';
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $removeViewsOnDelete = true;
    protected $appends = [
        'viewed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function author()
    {
        return $this->user();
    }

    public function categories()
    {
        return $this->belongsToMany(CategoryModel::class, 'categories_posts',
            'post_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(TagModel::class, 'tags_posts',
            'post_id', 'tag_id');
    }

    public function getViewedAttribute()
    {
        return (isset($this->views_count) ? $this->views_count : views($this)->count() );
    }

    public function url($params=[])
    {
        $url_params = [
            'post_slug' => $this->slug
        ];
        $url_params = array_unique(array_merge($url_params, $params));
        if (simple_cms_setting('type_post_url', 'default') == 'default' OR $this->type == 'page') {
            $url = route('simple_cms.blog.post', $url_params);
        }else{
            $url_params['year'] = $this->created_at->format('Y');
            $url_params['month'] = $this->created_at->format('m');
            $url = route('simple_cms.blog.post_archive', $url_params);
        }
        return $url;
    }

    public function url_archive($params=[])
    {
        $url_params = [
            'year' => $this->created_at->format('Y'),
            'month' => $this->created_at->format('m')
        ];
        $url_params = array_unique(array_merge($url_params, $params));
        return route('simple_cms.blog.archive', $url_params);
    }

    public function list_tag_categories($attributes = [], $linkEdit=false)
    {
        $hasEdit = hasRoutePermission('simple_cms.blog.backend.category.index');
        $lists = [];
        if ($this->categories) {
            foreach ($this->categories as $item) {
                if (isset($attributes['title'])) {
                    $attributes['title'] = trim($attributes['title']) . ' ' . $item->name;
                } else {
                    $attributes['title'] = $item->name;
                }
                unset($attributes['href']);
                array_push($lists, '<a href="' . (!$linkEdit ? $item->url() : ($hasEdit ? route('simple_cms.blog.backend.category.index') : '#')) . '" ' . \Html::attributes($attributes) . '>' . $item->name . '</a>');
            }
        }
        if ($this->type == 'gallery'){
            array_push($lists, '<a href="' . (!$linkEdit ? route('simple_cms.blog.galleries') : '#') . '" ' . \Html::attributes(['title' => trans('label.gallery')]) . '>' . trans('label.gallery') . '</a>');
        }
        return $lists;
    }
    public function list_tag_tags($attributes = [], $linkEdit=false)
    {
        $hasEdit = hasRoutePermission('simple_cms.blog.backend.tag.index');
        $lists = [];
        if ($this->tags) {
            foreach ($this->tags as $item) {
                if (isset($attributes['title'])) {
                    $attributes['title'] = trim($attributes['title']) . ' ' . $item->name;
                } else {
                    $attributes['title'] = $item->name;
                }
                unset($attributes['href']);
                array_push($lists, '<a href="' . (!$linkEdit ? $item->url() : ($hasEdit ? route('simple_cms.blog.backend.tag.index') : '#')) . '" ' . \Html::attributes($attributes) . '>' . $item->name . '</a>');
            }
        }
        return $lists;
    }

}
