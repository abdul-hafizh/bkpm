<?php

namespace SimpleCMS\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;

class NegaraModel extends Model
{

    protected $table = 'negara';
    protected $primaryKey = 'kode_negara';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['kode_negara'];

    protected $hidden = ['alpha_3', 'iso_3166_2', 'region', 'sub_region', 'intermediate_region', 'region_code', 'sub_region_code', 'intermediate_region_code'];

    public $timestamps = false;
}
