<?php

namespace SimpleCMS\Wilayah\Models;

use Illuminate\Database\Eloquent\Model;

class KabupatenModel extends Model
{

    protected $table = 'kabupaten';
    protected $primaryKey = 'kode_kabupaten';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /* protected $fillable = []; */

    protected $guarded = ['kode_kabupaten'];

    public $timestamps = false;
}
