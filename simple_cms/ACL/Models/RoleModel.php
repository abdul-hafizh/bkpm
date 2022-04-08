<?php

namespace SimpleCMS\ACL\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [];*/

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function User()
    {
        return $this->hasOne(User::class,'role_id','id');
    }
}
