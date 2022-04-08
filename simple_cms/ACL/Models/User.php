<?php

namespace SimpleCMS\ACL\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Plugins\BkpmUmkm\Models\SurveyModel;
use SimpleCMS\ACL\Notifications\ResetPasswordNotification;
use SimpleCMS\ACL\Notifications\VerifyEmailNotification;
use SimpleCMS\ActivityLog\Models\Activity;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'id_group',
        'id_role',
        'name',
        'username',
        'email',
        'password',
        'gender',
        'status',
        'path',
        'avatar',
        'created_at',
        'updated_at',
        'deleted_at'
    ];*/

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_media'      => 'array'
    ];

    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function group()
    {
        return $this->belongsTo(GroupModel::class, 'group_id','id');
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id','id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the password reset notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function getAvatar()
    {
        $avatar = 'avatar.png';
        return (!empty($this->avatar) ? $this->avatar : module_asset('core','images/'.$avatar) );
    }

    public function scopeCanPost()
    {
        return $this->whereHas('role', function ($q){
            $q->whereRaw('FIND_IN_SET("simple_cms.blog.backend.post.save_update", roles.permissions)')
                ->whereRaw('FIND_IN_SET("simple_cms.blog.backend.post.add", roles.permissions)')
                ->whereRaw('FIND_IN_SET("simple_cms.blog.backend.post.edit", roles.permissions)');
        });
    }

    public function services()
    {
        return $this->hasMany(UserServiceModel::class, 'user_id', 'id');
    }

    public function negara()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\NegaraModel::class, 'id_negara', 'kode_negara');
    }
    public function provinsi()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\ProvinsiModel::class, 'id_provinsi', 'kode_provinsi');
    }
    public function kabupaten()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\KabupatenModel::class, 'id_kabupaten', 'kode_kabupaten');
    }
    public function kecamatan()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\KecamatanModel::class, 'id_kecamatan', 'kode_kecamatan');
    }
    public function desa()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\DesaModel::class, 'id_desa', 'kode_desa');
    }

    public function surveys()
    {
        return $this->hasMany(SurveyModel::class, 'surveyor_id', 'id');
    }

    public function do_verified_surveys()
    {
        return $this->hasOne(Activity::class, 'causer_id', 'id')
            ->where([
                'activity_log.log_name' => 'LOG_SURVEY',
                'activity_log.group' => 'change_status_survey.verified'
                /*'activity_log.subject_type' => 'Plugins\BkpmUmkm\Models\SurveyModel'*/
            ])
            ->orderBy('activity_log.updated_at', 'DESC')
            ->groupBy('activity_log.subject_id');
    }

}
