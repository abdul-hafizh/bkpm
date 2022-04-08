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

class KemitraanModel extends Model
{
    use SoftDeletes;

    protected $table = 'kemitraan';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function company(){
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id')->where('companies.category', CATEGORY_COMPANY);
    }
    public function umkm(){
        return $this->belongsTo(CompanyModel::class, 'umkm_id', 'id')->where('companies.category', CATEGORY_UMKM);
    }

    public function getDateKemitraanAttribute()
    {
        if (!empty($this->start_date) && !empty($this->end_date)){
            return carbonParseTransFormat($this->start_date, 'Y/m-d') ." - " . carbonParseTransFormat($this->end_date, 'Y/m/d');
        }
        return '';
    }

}
