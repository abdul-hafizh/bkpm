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

class CompanyModel extends Model
{
    use SoftDeletes;

    protected $table = 'companies';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $guarded = ['id'];

    public $timestamps = true;
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function pic()
    {
        return $this->belongsTo(\SimpleCMS\ACL\Models\User::class, 'user_id', 'id');
    }
    public function surveyor_observasi()
    {
        return $this->belongsTo(\SimpleCMS\ACL\Models\User::class, 'surveyor_observasi_id', 'id');
    }
    public function sector()
    {
        return $this->belongsTo(BusinessSectorModel::class, 'business_sector_id');
    }

    public function kbli()
    {
        if ($this->kbli_multiple->count() <= 0){
            $this->sync_kbli_single_to_multiple();
        }
        return $this->kbli_multiple();
    }

    public function sync_kbli_single_to_multiple()
    {
        if($this->code_kbli) {
            $multi_kbli = [
                'code_kbli' => $this->code_kbli,
                'company_id' => $this->id
            ];
            CompanyKbliModel::updateOrCreate($multi_kbli, $multi_kbli);
        }
    }

    public function kbli_single()
    {
        return $this->belongsTo(KbliModel::class, 'code_kbli', 'code');
    }
    public function kbli_multiple()
    {
        return $this->belongsToMany(KbliModel::class, 'company_kbli', 'company_id', 'code_kbli', 'id', 'code')->withPivot(['company_id', 'code_kbli']);
    }

    public function survey()
    {
        return $this->hasOne(SurveyModel::class, 'company_id', 'id');
    }
    public function surveys()
    {
        return $this->hasMany(SurveyModel::class, 'company_id', 'id');
    }

    public function company_status()
    {
        return $this->hasOne(CompanyStatusModel::class, 'company_id', 'id');
    }
    public function companies_status()
    {
        return $this->hasMany(CompanyStatusModel::class, 'company_id', 'id');
    }

    public function kemitraan_company_umkm()
    {
        return $this->belongsToMany(self::class, 'kemitraan', 'company_id', 'umkm_id')->withPivot([
            'id',
            'company_id',
            'company_status',
            'company_status_description',
            'umkm_id',
            'umkm_status',
            'umkm_status_description',
            'status',
            'created_at',
            'updated_at'
        ]);
    }

    public function kemitraan_umkm_company()
    {
        return $this->belongsToMany(self::class, 'kemitraan', 'umkm_id', 'company_id')->withPivot([
            'id',
            'company_id',
            'company_status',
            'company_status_description',
            'umkm_id',
            'umkm_status',
            'umkm_status_description',
            'status',
            'created_at',
            'updated_at'
        ]);
    }

    public function pma_negara()
    {
        return $this->belongsTo(\SimpleCMS\Wilayah\Models\NegaraModel::class, 'pma_negara_id', 'kode_negara');
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
