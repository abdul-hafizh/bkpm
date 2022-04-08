<?php

namespace SimpleCMS\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinsiModel extends Model
{
    protected $table = 'provinsi';
    protected $primaryKey = 'kode_provinsi';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['kode_provinsi'];

    public $timestamps = false;
}
