<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 2:59 PM ---------
 */

namespace Plugins\BkpmUmkm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleCMS\ActivityLog\Models\Activity;

class SurveyModel extends Model
{
    use SoftDeletes;

    protected $table = 'surveys';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function company()
    {
        return $this->belongsTo(\Plugins\BkpmUmkm\Models\CompanyModel::class, 'company_id', 'id')->where('companies.category', CATEGORY_COMPANY);
    }
    public function umkm()
    {
        return $this->belongsTo(\Plugins\BkpmUmkm\Models\CompanyModel::class, 'company_id', 'id')->where('companies.category', CATEGORY_UMKM);
    }
    public function surveyor()
    {
        return $this->belongsTo(\SimpleCMS\ACL\Models\User::class, 'surveyor_id', 'id');
    }
    public function survey_result()
    {
        return $this->hasOne(SurveyResultModel::class, 'survey_id', 'id');
    }

    public function do_verified()
    {
        return $this->hasOne(Activity::class, 'subject_id', 'id')
            ->where([
                'activity_log.log_name'     => 'LOG_SURVEY',
                'activity_log.group'        => 'change_status_survey.verified',
                'activity_log.subject_type' => 'Plugins\BkpmUmkm\Models\SurveyModel'
            ])
            ->orderBy('activity_log.updated_at', 'DESC')
            ->groupBy('activity_log.subject_id');
    }

}
