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

class UmkmMassiveModel extends Model
{
    use SoftDeletes;

    protected $table = 'umkm_massive';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function kbli()
    {
        return $this->belongsTo(KbliModel::class, 'code_kbli', 'code');
    }

    public function survey()
    {
        return $this->hasOne(SurveyUmkmMassiveModel::class, 'id_umkm_massive', 'id');
    }

    public function surveys()
    {
        return $this->hasMany(SurveyUmkmMassiveModel::class, 'id_umkm_massive', 'id');
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

}
