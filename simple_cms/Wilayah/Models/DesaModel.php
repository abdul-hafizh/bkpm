<?php

namespace SimpleCMS\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;

class DesaModel extends Model
{

    protected $table = 'desa';
    protected $primaryKey = 'kode_desa';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['kode_desa'];

    public $timestamps = false;
}
