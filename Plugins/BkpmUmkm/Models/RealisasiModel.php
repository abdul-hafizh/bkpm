<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 2:59 PM ---------
 */

namespace Plugins\BkpmUmkm\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiModel extends Model
{
    protected $table = 'kemitraan';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function company(){
        return $this->belongsTo(CompanyModel::class, 'company_id', 'id')->where('companies.category', CATEGORY_COMPANY);
    }
    
}
