<?php

namespace SimpleCMS\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesPostsModel extends Model
{
    protected $table = 'categories_posts';
    protected $primaryKey = false;
    public $incrementing = false;
    protected $fillable = [
        'category_id',
        'post_id'
    ];
    public $timestamps = false;
}
