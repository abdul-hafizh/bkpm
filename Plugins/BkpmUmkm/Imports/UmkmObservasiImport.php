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

class UmkmObservasiImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    protected $request;
    protected $config;
    protected $identifier;
    protected $user;
    protected $category_company;
    protected $path_created = [];


    public function __construct($request)
    {
        $this->request = $request;
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->category_company = CATEGORY_UMKM;
        $this->user = auth()->user();
    }

    public function onRow(Row $row)
    {
        // TODO: Implement onRow() method.
        $row      = $row->toArray();

        $field_complete = (
            (isset($row['nama_usaha']) && !empty($row['nama_usaha'])) &&
            (isset($row['kode_negara']) && !empty($row['kode_negara'])) &&
            (isset($row['kode_provinsi']) && !empty($row['kode_provinsi'])) &&
            (isset($row['nama_direktur']) && !empty($row['nama_direktur']))
            // (isset($row['surveyor']) && !empty($row['surveyor']))
        );
        if ($field_complete) {

            /* Processing saving import */
            $data = [
                'name' => (isset($row['nama_usaha'])&&!empty($row['nama_usaha']) ? filter($row['nama_usaha']) : ''),
                'id_negara' => (isset($row['kode_negara'])&&!empty($row['kode_negara']) ? filter($row['kode_negara']) : ''),
                'id_provinsi' => (isset($row['kode_provinsi'])&&!empty($row['kode_provinsi']) ? filter($row['kode_provinsi']) : ''),
                'address' => (isset($row['alamat'])&&!empty($row['alamat']) ? filter($row['alamat']) : ''),
                'postal_code' => (isset($row['kode_pos'])&&!empty($row['kode_pos']) ? filter($row['kode_pos']) : ''),
                'name_director' => (isset($row['nama_direktur'])&&!empty($row['nama_direktur']) ? filter($row['nama_direktur']) : ''),
                'about' => (isset($row['tentang_usaha'])&&!empty($row['tentang_usaha']) ? filter($row['tentang_usaha']) : ''),

                'category'  => $this->category_company,
                'status'    => UMKM_OBSERVASI
            ];

            $get_user = null;
            $surveyor = trim($row['surveyor']);
            if(filter_var(strtolower($surveyor), FILTER_VALIDATE_EMAIL)) {
                $get_user = \SimpleCMS\ACL\Models\User::where('email', strtolower($surveyor))->first();
            }
            if (is_numeric($surveyor)){
                $get_user = \SimpleCMS\ACL\Models\User::where('id', $surveyor)->first();
            }
            if (is_string($surveyor)){
                $get_user = \SimpleCMS\ACL\Models\User::where('username', $surveyor)->first();
            }
            if ($get_user){
                $data['surveyor_observasi_id'] = $get_user->id;
            }
            if (isset($row['kode_kabupaten'])&&!empty($row['kode_kabupaten'])) {
                $data['id_kabupaten'] = filter($row['kode_kabupaten']);
            }elseif (isset($row['nama_kabupaten'])&&!empty($row['nama_kabupaten'])) {
                $parse_nama_kabupaten = \Str::upper(filter($row['nama_kabupaten']));
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('nama_kabupaten', $parse_nama_kabupaten)->first();
                if ($get_kabupaten) {
                    $data['id_kabupaten'] = $get_kabupaten->kode_kabupaten;
                }
            }
            if (isset($row['kode_kecamatan'])&&!empty($row['kode_kecamatan'])) {
                $data['id_kecamatan'] = filter($row['kode_kecamatan']);
            }elseif (isset($row['nama_kecamatan'])&&!empty($row['nama_kecamatan'])) {
                $parse_nama_kecamatan = \Str::upper(filter($row['nama_kecamatan']));
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('nama_kecamatan', $parse_nama_kecamatan)->first();
                if ($get_kecamatan) {
                    $data['id_kecamatan'] = $get_kecamatan->kode_kecamatan;
                }
            }
            if (isset($row['kode_desa'])&&!empty($row['kode_desa'])) {
                $data['id_desa'] = filter($row['kode_desa']);
            }elseif (isset($row['nama_desa'])&&!empty($row['nama_desa'])) {
                $parse_nama_desa = \Str::upper(filter($row['nama_desa']));
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('nama_desa', $parse_nama_desa)->first();
                if ($get_desa) {
                    $data['id_desa'] = $get_desa->kode_desa;
                }
            }

            if (isset($row['created_at'])&&!empty($row['created_at'])){
                $row['created_at'] = str_replace('/', '-', trim($row['created_at']));
                $data['created_at'] = \Carbon\Carbon::parse($row['created_at'])->format('Y-m-d H:i:s');
            }
            $check = \Plugins\BkpmUmkm\Models\CompanyModel::where([
                'name' => $data['name'],
                'id_provinsi' => $data['id_provinsi'],
                'category'  => $this->category_company,
                'status'    => UMKM_OBSERVASI
            ])->first();
            $slug = \Str::slug($data['name'], '-');
            if (!$check) {
                $path_upload_default = create_path_default($slug, public_path("companies/{$this->category_company}"));
                $data['path'] = $path_upload_default;
                array_push($this->path_created, $path_upload_default);
            }

            $company = \Plugins\BkpmUmkm\Models\CompanyModel::updateOrCreate([
                'name' => $data['name'],
                'id_provinsi' => $data['id_provinsi'],
                'category'  => $this->category_company,
                'status'    => UMKM_OBSERVASI
            ], $data);
            $message = 'Your import ' . trans("label.{$this->category_company}_observasi") . ': ' . $data['name'];
            $logProperties['attributes'] = $company->toArray();
            $log_name = "LOG_" . \Str::upper($this->category_company);
            activity_log($log_name, 'import', $message, $logProperties, $company);
            \DB::commit();
        }
    }

    public function rules(): array
    {
        $roles = [
            'nama_usaha' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama Usaha tidak diisi.');
                    }
                }
            ],
            'kode_negara' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Kode Negara tidak diisi.');
                    }
                    if (!empty($value) && !\SimpleCMS\Wilayah\Models\NegaraModel::where('kode_negara', $value)->count()){
                        $onFailure('Kode Negara tidak ada di referensi wilayah.');
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
            ],
            'kode_kabupaten' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (!empty($value) && !\SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $value)->count()){
                        $onFailure('Kode Kabupaten tidak ada di referensi wilayah.');
                    }
                }
            ],
            'kode_kecamatan' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (!empty($value) && !\SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $value)->count()){
                        $onFailure('Kode Kecamatan tidak ada di referensi wilayah.');
                    }
                }
            ],
            'kode_desa' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (!empty($value) && !\SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $value)->count()){
                        $onFailure('Kode Desa tidak ada di referensi wilayah.');
                    }
                }
            ],
            'nama_direktur' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama Direktur tidak diisi.');
                    }
                }
            ]
            // 'surveyor' => [
            //     function($attribute, $value, $onFailure) {
            //         $value = filter($value);
            //         if (empty($value)) {
            //             $onFailure('Surveyor tidak diisi.');
            //         }
            //     }
            // ]
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
