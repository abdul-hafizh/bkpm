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

class SurveyUmkmMassiveImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
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

        $transTitle = trans("label.survey_umkm_observasi_massive");
        $field_complete = (
            (isset($row['nama_surveyor']) && !empty($row['nama_surveyor'])) &&
            (isset($row['kode_provinsi_surveyor']) && !empty($row['kode_provinsi_surveyor'])) &&
            (isset($row['nama_umkm']) && !empty($row['nama_umkm'])) &&
            (isset($row['nama_pemilik']) && !empty($row['nama_pemilik']))
        );

        if ($field_complete) {
            /* Processing saving import */
            $data = [
                'latitude' => (isset($row['latitude'])&&!empty(trim($row['latitude'])) ? trim($row['latitude']) : NULL),
                'longitude' => (isset($row['longitude'])&&!empty(trim($row['longitude'])) ? trim($row['longitude']) : NULL),
                'nama_surveyor' => (isset($row['nama_surveyor'])&&!empty(trim($row['nama_surveyor'])) ? filter($row['nama_surveyor']) : NULL),
                'phone_surveyor' => (isset($row['phone_surveyor'])&&!empty(trim($row['phone_surveyor'])) ? filter($row['phone_surveyor']) : NULL),
                'address_surveyor' => (isset($row['address_surveyor'])&&!empty(trim($row['address_surveyor'])) ? filter($row['address_surveyor']) : NULL),
                'keterangan' => (isset($row['keterangan'])&&!empty(trim($row['keterangan'])) ? filter($row['keterangan']) : NULL),


                'name_umkm' => (isset($row['nama_umkm'])&&!empty(trim($row['nama_umkm'])) ? filter($row['nama_umkm']) : NULL),
                'nib_umkm' => (isset($row['nib_umkm'])&&!empty(trim($row['nib_umkm'])) ? filter($row['nib_umkm']) : NULL),
                'desc_kbli_umkm' => (isset($row['deskripsi_kbli'])&&!empty(trim($row['deskripsi_kbli'])) ? filter($row['deskripsi_kbli']) : NULL),
                'address_umkm' => (isset($row['alamat_umkm'])&&!empty(trim($row['alamat_umkm'])) ? filter($row['alamat_umkm']) : NULL),
                'name_director_umkm' => (isset($row['nama_pemilik'])&&!empty(trim($row['nama_pemilik'])) ? filter($row['nama_pemilik']) : NULL),
                'phone_director_umkm' => (isset($row['no_telp_pemilik'])&&!empty(trim($row['no_telp_pemilik'])) ? filter($row['no_telp_pemilik']) : NULL),
            ];

            if (isset($row['date_survey']) && !empty(trim($row['date_survey'])) && \Carbon\Carbon::parse(trim($row['date_survey']))) {
                $data['created_at'] = carbonParseTransFormat(trim($row['date_survey']), 'Y-m-d H:i:s');
                /*$data['date_survey'] = carbonParseTransFormat(trim($row['date_survey']), 'Y-m-d');*/
            }

            if (isset($row['kode_provinsi_surveyor']) && !empty(trim($row['kode_provinsi_surveyor']))) {
                $data['id_provinsi_surveyor'] = trim($row['kode_provinsi_surveyor']);
                $data['id_provinsi_umkm'] = trim($row['kode_provinsi_surveyor']);
                $get_provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $data['id_provinsi_surveyor'])->first();
                if ($get_provinsi){
                    $data['nama_provinsi_surveyor']  = $get_provinsi->nama_provinsi;
                    $data['nama_provinsi_umkm']  = $get_provinsi->nama_provinsi;
                }
            }


            if (isset($row['kode_kabupaten_surveyor'])&&!empty($row['kode_kabupaten_surveyor'])) {
                $data['id_kabupaten_surveyor'] = filter($row['kode_kabupaten_surveyor']);
                $data['id_kabupaten_umkm']      = $data['id_kabupaten_surveyor'];
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $data['id_kabupaten_surveyor'])->first();
                if ($get_kabupaten) {
                    $data['nama_kabupaten_surveyor'] = $get_kabupaten->nama_kabupaten;
                    $data['nama_kabupaten_umkm'] = $get_kabupaten->nama_kabupaten;
                }
            }elseif (isset($row['nama_kabupaten_surveyor'])&&!empty(trim($row['nama_kabupaten_surveyor']))) {
                $parse_nama_kabupaten = \Str::upper(filter($row['nama_kabupaten_surveyor']));
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('nama_kabupaten', $parse_nama_kabupaten)->first();
                if ($get_kabupaten) {
                    $data['id_kabupaten_surveyor'] = $get_kabupaten->kode_kabupaten;
                    $data['nama_kabupaten_surveyor'] = $get_kabupaten->nama_kabupaten;
                    $data['id_kabupaten_umkm'] = $get_kabupaten->kode_kabupaten;
                    $data['nama_kabupaten_umkm'] = $get_kabupaten->nama_kabupaten;
                }else{
                    $data['nama_kabupaten_surveyor'] = (isset($row['nama_kabupaten_surveyor']) ? trim($row['nama_kabupaten_surveyor']) : '');
                    $data['nama_kabupaten_umkm']    = $data['nama_kabupaten_surveyor'];
                }
            }
            if (isset($row['kode_kecamatan_surveyor'])&&!empty(trim($row['kode_kecamatan_surveyor']))) {
                $data['id_kecamatan_surveyor'] = filter($row['kode_kecamatan_surveyor']);
                $data['id_kecamatan_umkm'] = $data['id_kecamatan_surveyor'];
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $data['id_kecamatan_surveyor'])->first();
                if ($get_kecamatan) {
                    $data['nama_kecamatan_surveyor'] = $get_kecamatan->nama_kecamatan;
                    $data['nama_kecamatan_umkm'] = $get_kecamatan->nama_kecamatan;
                }
            }elseif (isset($row['nama_kecamatan_surveyor'])&&!empty(trim($row['nama_kecamatan_surveyor']))) {
                $parse_nama_kecamatan = \Str::upper(filter($row['nama_kecamatan_surveyor']));
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('nama_kecamatan', $parse_nama_kecamatan)->first();
                if ($get_kecamatan) {
                    $data['id_kecamatan_surveyor'] = $get_kecamatan->kode_kecamatan;
                    $data['nama_kecamatan_surveyor'] = $get_kecamatan->nama_kecamatan;
                    $data['id_kecamatan_umkm'] = $get_kecamatan->kode_kecamatan;
                    $data['nama_kecamatan_umkm'] = $get_kecamatan->nama_kecamatan;
                }else{
                    $data['nama_kecamatan_surveyor'] = (isset($row['nama_kecamatan_surveyor']) ? filter($row['nama_kecamatan_surveyor']) : '');
                    $data['nama_kecamatan_umkm']    = $data['nama_kecamatan_surveyor'];
                }
            }
            if (isset($row['kode_desa_surveyor'])&&!empty(trim($row['kode_desa_surveyor']))) {
                $data['id_desa_surveyor'] = filter($row['kode_desa_surveyor']);
                $data['id_desa_umkm'] = $data['id_desa_surveyor'];
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $data['id_desa_surveyor'])->first();
                if ($get_desa) {
                    $data['nama_desa_surveyor'] = $get_desa->nama_desa;
                    $data['nama_desa_umkm'] = $get_desa->nama_desa;
                }
            }elseif (isset($row['nama_desa_surveyor'])&&!empty(trim($row['nama_desa_surveyor']))) {
                $parse_nama_desa = \Str::upper(filter($row['nama_desa_surveyor']));
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('nama_desa', $parse_nama_desa)->first();
                if ($get_desa) {
                    $data['id_desa_surveyor'] = $get_desa->kode_desa;
                    $data['nama_desa_surveyor'] = $get_desa->nama_desa;
                    $data['id_desa_umkm'] = $get_desa->kode_desa;
                    $data['nama_desa_umkm'] = $get_desa->nama_desa;
                }else{
                    $data['nama_desa_surveyor'] = (isset($row['nama_desa_surveyor']) ? filter($row['nama_desa_surveyor']) : '');
                    $data['nama_desa_umkm'] = $data['nama_desa_surveyor'];
                }
            }

            /* Foto / Image */
            /*'foto_berita_acara' => ($request->input('foto_berita_acara') ? $request->input('foto_berita_acara') : []),
            'foto_legalitas_usaha' => ($request->input('foto_legalitas_usaha') ? $request->input('foto_legalitas_usaha') : []),
            'foto_tempat_usaha' => ($request->input('foto_tempat_usaha') ? $request->input('foto_tempat_usaha') : []),
            'foto_produk' => ($request->input('foto_produk') ? $request->input('foto_produk') : []),*/

            if (isset($row['foto_berita_acara'])&&!empty(trim($row['foto_berita_acara']))) {
                $data['foto_berita_acara'] = [];
                $foto_berita_acara = explode('|', trim($row['foto_berita_acara']));
                foreach ($foto_berita_acara as $fba) {
                    $result_decode = $this->decodeImageBase64Store($fba);
                    if (!empty($result_decode)) {
                        array_push($data['foto_berita_acara'], $result_decode);
                    }

                    /*if (preg_match('/^data:image\/(\w+);base64,/', $fba)) {
                        array_push($data['foto_berita_acara'], $fba);
                    }*/
                }
            }
            if (isset($row['foto_legalitas_usaha'])&&!empty(trim($row['foto_legalitas_usaha']))) {
                $data['foto_legalitas_usaha'] = [];
                $foto_legalitas_usaha = explode('|', trim($row['foto_legalitas_usaha']));
                foreach ($foto_legalitas_usaha as $fba) {
                    $result_decode = $this->decodeImageBase64Store($fba);
                    if (!empty($result_decode)) {
                        array_push($data['foto_legalitas_usaha'], $result_decode);
                    }

                    /*if (preg_match('/^data:image\/(\w+);base64,/', $fba)) {
                        array_push($data['foto_legalitas_usaha'], $fba);
                    }*/
                }
            }
            if (isset($row['foto_tempat_usaha'])&&!empty(trim($row['foto_tempat_usaha']))) {
                $data['foto_tempat_usaha'] = [];
                $foto_tempat_usaha = explode('|', trim($row['foto_tempat_usaha']));
                foreach ($foto_tempat_usaha as $fba) {
                    $result_decode = $this->decodeImageBase64Store($fba);
                    if (!empty($result_decode)) {
                        array_push($data['foto_tempat_usaha'], $result_decode);
                    }

                    /*if (preg_match('/^data:image\/(\w+);base64,/', $fba)) {
                        array_push($data['foto_tempat_usaha'], $fba);
                    }*/
                }
            }
            if (isset($row['foto_produk'])&&!empty(trim($row['foto_produk']))) {
                $data['foto_produk'] = [];
                $foto_produk = explode('|', trim($row['foto_produk']));
                foreach ($foto_produk as $fba) {
                    $result_decode = $this->decodeImageBase64Store($fba);
                    if (!empty($result_decode)) {
                        array_push($data['foto_produk'], $result_decode);
                    }

                    /*if (preg_match('/^data:image\/(\w+);base64,/', $fba)) {
                        array_push($data['foto_produk'], $fba);
                    }*/
                }
            }


            /*$check = \Plugins\BkpmUmkm\Models\UmkmMassiveModel::where(['nib' => $data['nib']])->first();
            if (!$check) {*/

                /*$slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/umkm-massive"));
                $data['path'] = $path_upload_default;
                array_push($this->path_created, $path_upload_default);*/
            /*}*/
            $create = true;
            if (!empty($data['nib_umkm']) && $check = \Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel::where(['nib_umkm' => $data['nib_umkm']])->count()){
                $create = false;
            }

            if ($create && ! $check = \Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel::whereRaw('LOWER(`name_umkm`) = ? ',[trim(strtolower($data['name_umkm']))])->where('id_provinsi_umkm', $data['id_provinsi_umkm'])->count() ) {

                /*$company = \Plugins\BkpmUmkm\Models\UmkmMassiveModel::query()->updateOrCreate(['nib' => $data['nib']], $data);*/
                $company = \Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel::create($data);
                $message = 'Import ' . $transTitle . ': ' . $data['name_umkm'];
                $logProperties['attributes'] = $company->toArray();
                $log_name = "LOG_SURVEY_UMKM_MASSIVE";
                activity_log($log_name, 'import', $message, $logProperties, $company);
                \DB::commit();
            }
        }
    }

    public function rules(): array
    {
        $roles = [
            'nama_surveyor' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama Surveyor tidak diisi.');
                    }
                }
            ],
            'nama_pemilik' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama pemilik tidak diisi.');
                    }
                }
            ],
            'nama_umkm' => [
                function($attribute, $value, $onFailure) {
                    $value = filter($value);
                    if (empty($value)) {
                        $onFailure('Nama UMKM tidak diisi.');
                    }
                }
            ],
            'kode_provinsi_surveyor' => [
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

    protected function decodeImageBase64Store($base64)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64)) {
            $data = substr($base64, strpos($base64, ',') + 1);
            $file = base64_decode($data);
            $path = public_path('companies/umkm-massive/combine-surveys');
            $create = \SimpleCMS\Core\Services\CoreService::createDirIfNotExists($path);

            $f = finfo_open();
            $mime_type = finfo_buffer($f, $file, FILEINFO_MIME_TYPE);
            $extension = explode('/', $mime_type);
            $extension = $extension[1];

            $file_name = \Str::random(10) . '-' . \Carbon\Carbon::now()->format('YmdHis') . '.'.$extension;
            $safeName = "{$path}/{$file_name}";

            $image = str_replace("data:{$mime_type};base64,", '', $base64);
            $image = str_replace(' ', '+', $image);
            \File::put($safeName, base64_decode($image));
            /*file_put_contents($safeName, $file);*/

            return 'companies/umkm-massive/combine-surveys/' . $file_name;
        }
        return '';
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
