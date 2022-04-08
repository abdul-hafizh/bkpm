<?php

namespace SimpleCMS\Slider\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleCMS\Translation\Traits\Translatable;

class SliderModel extends Model
{
    use SoftDeletes, Translatable;
    protected $translatableAttributes = ['title', 'description'];
    protected $table = 'sliders';
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
