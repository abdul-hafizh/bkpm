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

class SurveyUmkmMassiveModel extends Model
{
    use SoftDeletes;

    protected $table = 'survey_umkm_massive';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'foto_berita_acara'     => \SimpleCMS\Core\Casts\JsonCast::class,
        'foto_legalitas_usaha'  => \SimpleCMS\Core\Casts\JsonCast::class,
        'foto_tempat_usaha'     => \SimpleCMS\Core\Casts\JsonCast::class,
        'foto_produk'           => \SimpleCMS\Core\Casts\JsonCast::class
    ];

    public function umkm()
    {
        return $this->belongsTo(UmkmMassiveModel::class, 'id_umkm_massive', 'id');
    }

    public function negara()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\NegaraModel::class, 'id_negara_surveyor', 'kode_negara');
    }
    public function provinsi()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\ProvinsiModel::class, 'id_provinsi_surveyor', 'kode_provinsi');
    }
    public function kabupaten()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\KabupatenModel::class, 'id_kabupaten_surveyor', 'kode_kabupaten');
    }
    public function kecamatan()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\KecamatanModel::class, 'id_kecamatan_surveyor', 'kode_kecamatan');
    }
    public function desa()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\DesaModel::class, 'id_desa_surveyor', 'kode_desa');
    }

}
