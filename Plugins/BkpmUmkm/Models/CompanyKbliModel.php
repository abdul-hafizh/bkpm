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

class CompanyKbliModel extends Model
{
    protected $table = 'company_kbli';
    protected $primaryKey = null;
    public $incrementing = false;

    protected $guarded = [];

    public $timestamps = false;

}
