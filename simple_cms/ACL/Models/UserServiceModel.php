<?php

namespace SimpleCMS\ACL\Models;

use Illuminate\Database\Eloquent\Model;

class UserServiceModel extends Model
{
    protected $table = 'user_services';
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
