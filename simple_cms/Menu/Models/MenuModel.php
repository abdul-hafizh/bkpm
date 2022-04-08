<?php

namespace SimpleCMS\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuModel extends Model
{
    use SoftDeletes;

    protected $table = 'menus';
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
}
