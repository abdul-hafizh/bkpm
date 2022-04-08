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
use Plugins\BkpmUmkm\Models\CompanyKbliModel;

class CompaniesImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    protected $request;
    protected $config;
    protected $identifier;
    protected $user;
    protected $category_company;
    protected $path_created = [];


    public function __construct($request, $category_company)
    {
        $this->request = $request;
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->category_company = $category_company;
        $this->user = auth()->user();
    }

    public function onRow(Row $row)
    {
        // TODO: Implement onRow() method.
        $row      = $row->toArray();

        $field_complete = false;
        $transTitle = trans("label.index_{$this->category_company}");
        switch ($this->category_company)
        {
            case CATEGORY_COMPANY:
                $field_complete = (
                    (isset($row['kode_kbli']) && !empty($row['kode_kbli'])) &&
                    (isset($row['pmdn_pma']) && !empty($row['pmdn_pma'])) &&
                    (isset($row['nib']) && !empty($row['nib'])) &&
                    (isset($row['nama_usaha']) && !empty($row['nama_usaha'])) &&
                    (isset($row['telp']) && !empty($row['telp'])) &&
                    (isset($row['kode_negara']) && !empty($row['kode_negara'])) &&
                    (isset($row['kode_provinsi']) && !empty($row['kode_provinsi'])) &&
                    (isset($row['nama_direktur']) && !empty($row['nama_direktur'])) &&
                    (isset($row['nama_pic']) && !empty($row['nama_pic'])) &&
                    (isset($row['email_pic']) && !empty($row['email_pic'])) &&
                    (isset($row['phone_pic']) && !empty($row['phone_pic'])) &&
                    (isset($row['password_pic']) && !empty($row['password_pic']))
                );
                break;
            case CATEGORY_UMKM:
                $transTitle = trans("label.{$this->category_company}_potensial");
                $field_complete = (
                    (isset($row['kode_kbli']) && !empty($row['kode_kbli'])) &&
                    (isset($row['nib']) && !empty($row['nib'])) &&
                    (isset($row['nama_usaha']) && !empty($row['nama_usaha'])) &&
                    (isset($row['telp']) && !empty($row['telp'])) &&
                    (isset($row['kode_negara']) && !empty($row['kode_negara'])) &&
                    (isset($row['kode_provinsi']) && !empty($row['kode_provinsi'])) &&
                    (isset($row['nama_direktur']) && !empty($row['nama_direktur'])) &&
                    (isset($row['nama_pic']) && !empty($row['nama_pic'])) &&
                    (isset($row['email_pic']) && !empty($row['email_pic'])) &&
                    (isset($row['phone_pic']) && !empty($row['phone_pic'])) &&
                    (isset($row['password_pic']) && !empty($row['password_pic']))
                );
                break;
        }

        if ($field_complete) {
            $get_user = \SimpleCMS\ACL\Models\User::where('email', filter($row['email_pic']))->first();
            if (!$get_user){

                /* Processing saving import */
                $data = [
                    'code' => (isset($row['kode'])&&!empty($row['kode']) ? filter($row['kode']) : ''),
                    'name' => (isset($row['nama_usaha'])&&!empty($row['nama_usaha']) ? filter($row['nama_usaha']) : ''),
                    'npwp' => (isset($row['npwp'])&&!empty($row['npwp']) ? filter($row['npwp']) : ''),
                    'type' => (isset($row['type'])&&!empty($row['type']) ? filter($row['type']) : ''),
                    'pmdn_pma' => (isset($row['pmdn_pma'])&&!empty($row['pmdn_pma']) ? \Str::upper(filter($row['pmdn_pma'])) : ''),
                    'nib' => (isset($row['nib'])&&!empty($row['nib']) ? filter($row['nib']) : ''),
                    'email' => (isset($row['email'])&&!empty($row['email']) ? \Str::lower(filter($row['email'])) : ''),
                    'telp' => (isset($row['telp'])&&!empty($row['telp']) ? filter($row['telp']) : ''),
                    'fax' => (isset($row['fax'])&&!empty($row['fax']) ? filter($row['fax']) : ''),
                    'id_negara' => (isset($row['kode_negara'])&&!empty($row['kode_negara']) ? filter($row['kode_negara']) : ''),
                    'id_provinsi' => (isset($row['kode_provinsi'])&&!empty($row['kode_provinsi']) ? filter($row['kode_provinsi']) : ''),
                    'address' => (isset($row['alamat'])&&!empty($row['alamat']) ? filter($row['alamat']) : ''),
                    'postal_code' => (isset($row['kode_pos'])&&!empty($row['kode_pos']) ? filter($row['kode_pos']) : ''),
                    'name_director' => (isset($row['nama_direktur'])&&!empty($row['nama_direktur']) ? filter($row['nama_direktur']) : ''),
                    'email_director' => (isset($row['email_direktur'])&&!empty($row['email_direktur']) ? \Str::lower(filter($row['email_direktur'])) : ''),
                    'phone_director' => (isset($row['phone_direktur'])&&!empty($row['phone_direktur']) ? filter($row['phone_direktur']) : ''),
                    'name_pic' => (isset($row['nama_pic'])&&!empty($row['nama_pic']) ? filter($row['nama_pic']) : ''),
                    'email_pic' => (isset($row['email_pic'])&&!empty($row['email_pic']) ? \Str::lower(filter($row['email_pic'])) : ''),
                    'phone_pic' => (isset($row['phone_pic'])&&!empty($row['phone_pic']) ? filter($row['phone_pic']) : ''),
                    'logo' => (isset($row['logo'])&&!empty($row['logo']) ? filter($row['logo']) : ''),
                    'infrastructure' => (isset($row['sarana_usaha'])&&!empty($row['sarana_usaha']) ? filter($row['sarana_usaha']) : ''),
                    'about' => (isset($row['tentang_usaha'])&&!empty($row['tentang_usaha']) ? filter($row['tentang_usaha']) : ''),
                    'longitude' => (isset($row['longitude'])&&!empty($row['longitude']) ? filter($row['longitude']) : ''),
                    'latitude' => (isset($row['latitude'])&&!empty($row['latitude']) ? filter($row['latitude']) : ''),
                    'total_employees' => (isset($row['jumlah_tenaga_kerja'])&&!empty($row['jumlah_tenaga_kerja']) ? filter($row['jumlah_tenaga_kerja']) : 0),
                    'investment_plan' => (isset($row['rencana_investasi'])&&!empty($row['rencana_investasi']) ? str_replace([',', '.'], '', filter($row['rencana_investasi'])) : 0),

                    'net_worth' => (isset($row['kekayaan_bersih'])&&!empty($row['kekayaan_bersih']) ? str_replace([',', '.'], '', filter($row['kekayaan_bersih'])) : 0),
                    'omset_every_year' => (isset($row['perkiraan_modal_usaha'])&&!empty($row['perkiraan_modal_usaha']) ? str_replace([',', '.'], '', filter($row['perkiraan_modal_usaha'])) : 0),
                    'estimated_venture_capital' => (isset($row['perkiraan_hasil_penjualan_pertahun'])&&!empty($row['perkiraan_hasil_penjualan_pertahun']) ? str_replace([',', '.'], '', filter($row['perkiraan_hasil_penjualan_pertahun'])) : 0),

                    'category'  => $this->category_company,
                    'status'    => UMKM_POTENSIAL
                ];

                if (isset($row['sektor_bisnis_id'])&&!empty($row['sektor_bisnis_id'])) {
                    $data['business_sector_id'] = filter($row['sektor_bisnis_id']);
                }

                if (isset($row['tanggal_nib'])&&!empty($row['tanggal_nib'])) {
                    $date_nib = filter($row['tanggal_nib']);
                    $data['date_nib'] = parseDateImport($date_nib, 'Y-m-d');
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

                $user = [
                    'name' => $data['name_pic'],
                    'mobile_phone' => $data['phone_pic']
                ];

                $check = \Plugins\BkpmUmkm\Models\CompanyModel::where(['nib' => $data['nib']])->first();
                if (!$check) {
                    $username = \Str::slug($data['name_pic'], '_');
                    $username = \SimpleCMS\ACL\Services\RegisterService::generateSlug($data['email_pic'], $username);
                    $user['username'] = $username;
                    $user['password'] = bcrypt(trim($row['password_pic']));
                    $user['group_id'] = GROUP_INVESTOR;
                    $user['role_id'] = GROUP_INVESTOR;
                    $user['email'] = $data['email_pic'];
                    $user['status'] = 1;
                    $user = \SimpleCMS\ACL\Models\User::create($user);
                    $data['user_id'] = $user->id;

                    $slug = \Str::slug($data['name'], '-');
                    $path_upload_default = create_path_default($slug, public_path("companies/{$this->category_company}"));
                    $data['path'] = $path_upload_default;
                    array_push($this->path_created, $path_upload_default);
                }

                $company = \Plugins\BkpmUmkm\Models\CompanyModel::query()->updateOrCreate(['nib' => $data['nib']], $data);
                CompanyKbliModel::where('company_id', $company->id)->forceDelete();
                if (isset($row['kode_kbli'])&&!empty($row['kode_kbli'])) {
                    $kode_kbli = explode(',', $row['kode_kbli']);
                    foreach ($kode_kbli as $kbli) {
                        $multi_kbli = [
                            'code_kbli' => $kbli,
                            'company_id' => $company->id
                        ];
                        CompanyKbliModel::updateOrCreate($multi_kbli, $multi_kbli);
                    }
                }

                $message = 'Import ' . $transTitle . ': ' . $data['name'];
                $logProperties['attributes'] = $company->toArray();
                $log_name = "LOG_" . \Str::upper($this->category_company);
                activity_log($log_name, 'import', $message, $logProperties, $company);
                \DB::commit();
            }
        }
    }

    public function rules(): array
    {
        $roles = [
            'kode_kbli' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Kode KBLI tidak diisi.');
                    }
                    if (!empty($value) && !\Plugins\BkpmUmkm\Models\KbliModel::where('code', $value)->count()){
                        $onFailure('Kode KBLI tidak ada di referensi KBLI.');
                    }
                }
            ],
            'nib' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('NIB tidak diisi.');
                    }
                    if (!empty($value) && \Plugins\BkpmUmkm\Models\CompanyModel::where('nib', $value)->count()){
                        $onFailure('NIB sudah digunakan.');
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
            'telp' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Telp tidak diisi.');
                    }
                    /*if (!empty($value) && \Plugins\BkpmUmkm\Models\CompanyModel::where('telp', $value)->count()){
                        $onFailure('Telp sudah digunakan.');
                    }*/
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
            ],
            'nama_pic' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama PIC tidak diisi.');
                    }
                }
            ],
            'email_pic' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Email PIC tidak diisi.');
                    }
                    if (!empty($value) && \SimpleCMS\ACL\Models\User::where('email', $value)->count()){
                        $onFailure('Email PIC sudah digunakan.');
                    }
                }
            ],
            'phone_pic' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Phone PIC tidak diisi.');
                    }
                    if (!empty($value) && \SimpleCMS\ACL\Models\User::where('mobile_phone', $value)->count()){
                        $onFailure('Phone PIC sudah digunakan.');
                    }
                }
            ],
            'password_pic' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Password PIC tidak diisi.');
                    }
                }
            ]
        ];
        switch ($this->category_company)
        {
            case CATEGORY_COMPANY:
                $roles['pmdn_pma'] = [
                    function($attribute, $value, $onFailure) {
                        $value = filter($value);
                        if (empty($value)) {
                            $onFailure('PMDN/PMA tidak diisi.');
                        }
                        if (!empty($value) && !in_array($value, $this->config['pmdn_pma'])){
                            $onFailure('PMDN/PMA tidak ada di daftar.');
                        }
                    }
                ];
                break;
            case CATEGORY_UMKM:

                break;
        }

        $roles['sektor_bisnis_id'] = [
            function($attribute, $value, $onFailure) {
                $value = filter($value);
                if (!empty($value) && !\Plugins\BkpmUmkm\Models\BusinessSectorModel::where('id', $value)->count()){
                    $onFailure('Sektor Bisnis tidak ada di referensi Sektor Bisnis.');
                }
            }
        ];
        $roles['kode'] = [
            function($attribute, $value, $onFailure) {
                $value = filter($value);
                if (!empty($value) && \Plugins\BkpmUmkm\Models\CompanyModel::where('code', $value)->count()){
                    $onFailure('Kode sudah digunakan.');
                }
            }
        ];
        $roles['npwp'] = [
            function($attribute, $value, $onFailure) {
                $value = filter($value);
                if (!empty($value) && \Plugins\BkpmUmkm\Models\CompanyModel::where('npwp', $value)->count()){
                    $onFailure('NPWP sudah digunakan.');
                }
            }
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
