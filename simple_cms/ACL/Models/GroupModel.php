<?php

namespace SimpleCMS\ACL\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupModel extends Model
{
    use SoftDeletes;

    protected $table = 'groups';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->hasOne(User::class,'group_id','id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'group_id','id');
    }
}
