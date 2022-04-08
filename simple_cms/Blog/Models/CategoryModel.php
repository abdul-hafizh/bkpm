<?php

namespace SimpleCMS\Blog\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleCMS\Translation\Traits\Translatable;

class CategoryModel extends Model
{
    use SoftDeletes, Translatable;
    protected $translatableAttributes = ['name', 'description'];
    protected $table = 'categories';
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

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function subs()
    {
        return $this->hasMany(self::class,'parent_id', 'id');
        /*return $this->hasManyThrough(self::class, self::class, 'parent_id', 'parent_id');*/
    }

    public function children()
    {
        return $this->subs();
    }
    public function posts()
    {
        return $this->belongsToMany(PostModel::class, 'categories_posts',
            'category_id','post_id')->withPivot('category_id', 'post_id');
    }

    protected function _treeview($whereType='post')
    {
        return self::select('categories.id','categories.parent_id','categories.name as text')->whereNull('parent_id')->with(['children' => function($q) use($whereType){
            $q->select('categories.id','categories.parent_id','categories.name as text')->with(['children' => function($q) use($whereType){
                $q->select('categories.id','categories.parent_id','categories.name as text')->with(['children' => function($q) use($whereType){
                    $q->select('categories.id','categories.parent_id','categories.name as text')->whereType($whereType)->orderBy('name','ASC');
                }])->whereType($whereType)->orderBy('name','ASC');
            }])->whereType($whereType)->orderBy('name','ASC');
        }])->whereType($whereType)->orderBy('name','ASC')->get();
    }

    public function url($params=[])
    {
        $url_params = [
            'post_slug' => $this->slug
        ];
        $url_params = array_unique(array_merge($url_params, $params));
        return route('simple_cms.blog.category', $url_params);
    }
}
