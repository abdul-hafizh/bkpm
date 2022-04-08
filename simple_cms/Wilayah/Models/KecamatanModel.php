<?php

namespace SimpleCMS\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;

class KecamatanModel extends Model
{

    protected $table = 'kecamatan';
    protected $primaryKey = 'kode_kecamatan';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['kode_kecamatan'];

    public $timestamps = false;
}
