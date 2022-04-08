<?php

namespace SimpleCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class TagsPostsModel extends Model
{
    protected $table = 'tags_posts';
    protected $primaryKey = 'tag_id';
    public $incrementing = false;
    protected $fillable = [
        'tag_id',
        'post_id'
    ];
    public $timestamps = false;
}
