<?php

namespace SimpleCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagModel extends Model
{
    use SoftDeletes;

    protected $table = 'tags';
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

    public function posts()
    {
        return $this->belongsToMany(PostModel::class, 'tags_posts',
            'tag_id','post_id');
    }

    public function url($params=[])
    {
        $url_params = [
            'post_slug' => $this->slug
        ];
        $url_params = array_unique(array_merge($url_params, $params));
        return route('simple_cms.blog.tag', $url_params);
    }
}
