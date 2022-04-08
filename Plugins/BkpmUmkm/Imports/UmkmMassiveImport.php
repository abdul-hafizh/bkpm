<?php
namespace Plugins\BkpmUmkm\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class UmkmMassiveImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    protected $request;
    protected $config;
    protected $identifier;
    protected $user;
    protected $path_created = [];


    public function __construct($request)
    {
        $this->request = $request;
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->user = auth()->user();
    }

    public function onRow(Row $row)
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // TODO: Implement onRow() method.
        $row      = $row->toArray();

        $field_complete = false;
        $transTitle = trans("label.umkm_observasi_massive");
        $field_complete = (
            (isset($row['nib']) && !empty($row['nib'])) &&
            (isset($row['nama_usaha']) && !empty($row['nama_usaha'])) &&
            (isset($row['nama_pemilik']) && !empty($row['nama_pemilik'])) &&
            (isset($row['kode_provinsi']) && !empty($row['kode_provinsi']))
        );

        if ($field_complete) {
            /* Processing saving import */
            $data = [
                'name' => (isset($row['nama_usaha'])&&!empty($row['nama_usaha']) ? filter($row['nama_usaha']) : ''),
                'nib' => (isset($row['nib'])&&!empty($row['nib']) ? filter($row['nib']) : ''),
                'sector' => (isset($row['sector'])&&!empty($row['sector']) ? filter($row['sector']) : ''),
                'id_negara' => '360',
                'id_provinsi' => (isset($row['kode_provinsi'])&&!empty($row['kode_provinsi']) ? filter($row['kode_provinsi']) : ''),
                'address' => (isset($row['alamat_usaha'])&&!empty($row['alamat_usaha']) ? filter($row['alamat_usaha']) : ''),
                'postal_code' => (isset($row['kode_pos'])&&!empty($row['kode_pos']) ? filter($row['kode_pos']) : ''),
                'name_director' => (isset($row['nama_pemilik'])&&!empty($row['nama_pemilik']) ? filter($row['nama_pemilik']) : ''),
                'email_director' => (isset($row['email'])&&!empty($row['email']) ? \Str::lower(trim($row['email'])) : ''),
                'phone_director' => (isset($row['telp'])&&!empty($row['telp']) ? str_replace(["'", "`"], '', trim($row['telp'])) : ''),
                'total_employees' => (isset($row['jumlah_tenaga_kerja'])&&!empty($row['jumlah_tenaga_kerja']) ? (int) trim($row['jumlah_tenaga_kerja']) : 0),
                'net_worth' => (isset($row['kekayaan_bersih'])&&!empty($row['kekayaan_bersih']) ? (int) str_replace([',', '.'], '', trim($row['kekayaan_bersih'])) : 0),
                'omset_every_year' => (isset($row['hasil_penjualan_pertahun'])&&!empty($row['hasil_penjualan_pertahun']) ? (int) str_replace([',', '.'], '', trim($row['hasil_penjualan_pertahun'])) : 0),
                'startup_capital' => (isset($row['modal_usaha'])&&!empty($row['modal_usaha']) ? (int) str_replace([',', '.'], '', trim($row['modal_usaha'])) : 0)
            ];

            if (isset($row['kode_kbli'])&&!empty($row['kode_kbli'])) {
                $data['code_kbli'] = filter($row['kode_kbli']);
            }

            $get_provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $data['id_provinsi'])->first();
            if ($get_provinsi){
                $data['nama_provinsi']  = $get_provinsi->nama_provinsi;
            }

            if (isset($row['kode_kabupaten'])&&!empty($row['kode_kabupaten'])) {
                $data['id_kabupaten'] = filter($row['kode_kabupaten']);
            }elseif (isset($row['nama_kabupaten'])&&!empty($row['nama_kabupaten'])) {
                $parse_nama_kabupaten = \Str::upper(filter($row['nama_kabupaten']));
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('nama_kabupaten', $parse_nama_kabupaten)->first();
                if ($get_kabupaten) {
                    $data['id_kabupaten'] = $get_kabupaten->kode_kabupaten;
                    $data['nama_kabupaten'] = $get_kabupaten->nama_kabupaten;
                }else{
                    $data['nama_kabupaten'] = (isset($row['nama_kabupaten']) ? $row['nama_kabupaten'] : '');
                }
            }
            if (isset($row['kode_kecamatan'])&&!empty($row['kode_kecamatan'])) {
                $data['id_kecamatan'] = filter($row['kode_kecamatan']);
            }elseif (isset($row['nama_kecamatan'])&&!empty($row['nama_kecamatan'])) {
                $parse_nama_kecamatan = \Str::upper(filter($row['nama_kecamatan']));
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('nama_kecamatan', $parse_nama_kecamatan)->first();
                if ($get_kecamatan) {
                    $data['id_kecamatan'] = $get_kecamatan->kode_kecamatan;
                    $data['nama_kecamatan'] = $get_kecamatan->nama_kecamatan;
                }else{
                    $data['nama_kecamatan'] = (isset($row['nama_kecamatan']) ? $row['nama_kecamatan'] : '');
                }
            }
            if (isset($row['kode_desa'])&&!empty($row['kode_desa'])) {
                $data['id_desa'] = filter($row['kode_desa']);
            }elseif (isset($row['nama_desa'])&&!empty($row['nama_desa'])) {
                $parse_nama_desa = \Str::upper(filter($row['nama_desa']));
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('nama_desa', $parse_nama_desa)->first();
                if ($get_desa) {
                    $data['id_desa'] = $get_desa->kode_desa;
                    $data['nama_desa'] = $get_desa->nama_desa;
                }else{
                    $data['nama_desa'] = (isset($row['nama_desa']) ? $row['nama_desa'] : '');
                }
            }

            /*$check = \Plugins\BkpmUmkm\Models\UmkmMassiveModel::where(['nib' => $data['nib']])->first();
            if (!$check) {*/

                /*$slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/umkm-massive"));
                $data['path'] = $path_upload_default;
                array_push($this->path_created, $path_upload_default);*/
            /*}*/

            /*$company = \Plugins\BkpmUmkm\Models\UmkmMassiveModel::query()->updateOrCreate(['nib' => $data['nib']], $data);*/
            $company = \Plugins\BkpmUmkm\Models\UmkmMassiveModel::create($data);
            $message = 'Import ' . $transTitle . ': ' . $data['name'];
            $logProperties['attributes'] = $company->toArray();
            $log_name = "LOG_UMKM_MASSIVE";
            activity_log($log_name, 'import', $message, $logProperties, $company);
            \DB::commit();
        }
    }

    public function rules(): array
    {
        $roles = [
            'nib' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('NIB tidak diisi.');
                    }
                }
            ],
            'nama_usaha' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama Usaha tidak diisi.');
                    }
                }
            ],
            'nama_pemilik' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama Pemilik tidak diisi.');
                    }
                }
            ],
            'kode_provinsi' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Kode Provinsi tidak diisi.');
                    }
                    if (!empty($value) && !\SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $value)->count()){
                        $onFailure('Kode Provinsi tidak ada di referensi wilayah.');
                    }
                }
            ]
        ];
        return $roles;
    }

    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        \DB::rollback();
        // Handle the exception how you'd like.
        if (count($this->path_created)){
            foreach ($this->path_created as $item) {
                if(is_dir($item)){
                    deleteTreeFolder($item);
                }
            }
        }
    }
}
