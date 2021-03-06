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

class SurveyResultModel extends Model
{
    use SoftDeletes;

    protected $table = 'survey_results';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'data'      => \SimpleCMS\Core\Casts\JsonCast::class,
        'documents' => \SimpleCMS\Core\Casts\JsonCast::class
    ];

    public function survey()
    {
        return $this->belongsTo(SurveyModel::class, 'survey_id', 'id');
    }

}
