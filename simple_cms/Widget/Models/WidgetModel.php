<?php

namespace SimpleCMS\Widget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WidgetModel extends Model
{
    use SoftDeletes;

    protected $table = 'widgets';
    protected $primaryKey = 'id';
    public $incrementing = false;
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
