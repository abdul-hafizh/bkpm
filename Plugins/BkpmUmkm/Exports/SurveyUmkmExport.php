<?php

namespace Plugins\BkpmUmkm\Exports;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Plugins\BkpmUmkm\Models\KbliModel;
use Plugins\BkpmUmkm\Models\SurveyModel;

class SurveyUmkmExport extends DefaultValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, WithTitle, WithStyles, WithEvents
{
    use Exportable;

    protected $user;
    protected $status = '';
    protected $periode;

    public function __construct()
    {
        $this->user = auth()->user();
        if (request()->get('status')){
            $this->status = encrypt_decrypt(request()->get('status'));
        }
        $this->periode = (request()->has('periode') && filter(request()->input('periode')) != '' ? filter(request()->input('periode')) : \Carbon\Carbon::now()->format('Y'));
    }

    public function query()
    {
        // TODO: Implement query() method.
        $survey = SurveyModel::whereHas('umkm')->with(['umkm', 'umkm.provinsi', 'surveyor', 'survey_result'])->whereYear('surveys.created_at', $this->periode);
        if (!empty($this->status)){
            $survey->whereStatus($this->status);
        }
        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
                $survey->where('surveys.surveyor_id', $this->user->id);
                break;
            case GROUP_QC_KORPROV:
                $survey->whereHas('surveyor', function ($q){
                    $q->where('users.id_provinsi', $this->user->id_provinsi);
                });
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $survey->whereHas('surveyor', function ($q) use($provinces){
                    $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                    $q->whereIn('users.id_provinsi', $provinces);
                });
                break;
            default:

                break;
        }
        return $survey;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A2:CC2')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            }
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }
        return parent::bindValue($cell, $value); // TODO: Change the autogenerated stub
    }

    public function map($row): array
    {
        $data = false;
        $surveyor = false;
        if ($row->survey_result) {
            $survey_result = $row->survey_result;
            $data = $survey_result->data;
            $surveyor = $row->surveyor;
        }
        if ($data){
            $kblis = [];
            $responden = (isset($data['responden'])&&$data['responden'] ? $data['responden']: '');
            $profil_usaha    = (isset($data['profil_usaha'])&&$data['profil_usaha'] ? $data['profil_usaha'] : '');
            $profil_usaha_negara    = (isset($profil_usaha['negara'])&&!empty($profil_usaha['negara']) ? \SimpleCMS\Wilayah\Models\NegaraModel::select('kode_negara', 'nama_negara')->where('kode_negara', $profil_usaha['negara'])->first()->nama_negara : '');
            $profil_usaha_provinsi  = (isset($profil_usaha['provinsi'])&&!empty($profil_usaha['provinsi']) ? \SimpleCMS\Wilayah\Models\ProvinsiModel::select('kode_provinsi', 'nama_provinsi')->where('kode_provinsi', $profil_usaha['provinsi'])->first()->nama_provinsi : '');
            $profil_usaha_kabupaten = (isset($profil_usaha['kabupaten'])&&!empty($profil_usaha['kabupaten']) ? \SimpleCMS\Wilayah\Models\KabupatenModel::select('kode_kabupaten', 'nama_kabupaten')->where('kode_kabupaten', $profil_usaha['kabupaten'])->first()->nama_kabupaten : '');
            $profil_usaha_kecamatan = (isset($profil_usaha['kecamatan'])&&!empty($profil_usaha['kecamatan']) ? \SimpleCMS\Wilayah\Models\KecamatanModel::select('kode_kecamatan', 'nama_kecamatan')->where('kode_kecamatan', $profil_usaha['kecamatan'])->first()->nama_kecamatan : '');
            $profil_usaha_desa      = (isset($profil_usaha['desa'])&&!empty($profil_usaha['desa']) ? \SimpleCMS\Wilayah\Models\DesaModel::select('kode_desa', 'nama_desa')->where('kode_desa', $profil_usaha['desa'])->first()->nama_desa : '');

            $dokumentasi_profil_usaha_penghargaan    = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['penghargaan']) ? $data['dokumentasi_profil_usaha']['penghargaan'] : []);
            $dokumentasi_profil_usaha_penghargaan_files = '';
            foreach($dokumentasi_profil_usaha_penghargaan as $penghargaan){
                $dokumentasi_profil_usaha_penghargaan_files .= asset($penghargaan['file']) . "\n";
            }

            $dokumentasi_profil_usaha_sertifikasi_mutu    = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['sertifikasi']['mutu']) ? $data['dokumentasi_profil_usaha']['sertifikasi']['mutu'] : ['file'=>'']);
            $dokumentasi_profil_usaha_sertifikasi_halal  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['sertifikasi']['halal_upload']) ? $data['dokumentasi_profil_usaha']['sertifikasi']['halal_upload'] : ['file'=>'']);
            $dokumentasi_profil_usaha_sertifikasi_lainya  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['sertifikasi']['lainya']) ? $data['dokumentasi_profil_usaha']['sertifikasi']['lainya'] : []);
            $dokumentasi_profil_usaha_sertifikasi_lainya_files = '';
            foreach($dokumentasi_profil_usaha_sertifikasi_lainya as $lainya){
                $dokumentasi_profil_usaha_sertifikasi_lainya_files .= asset($lainya['file']) . "\n";
            }

            $dokumentasi_profil_usaha_legalitas_siup    = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['legalitas']['siup']) ? $data['dokumentasi_profil_usaha']['legalitas']['siup'] : ['file'=>'']);
            $dokumentasi_profil_usaha_legalitas_tdp  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['legalitas']['tdp']) ? $data['dokumentasi_profil_usaha']['legalitas']['tdp'] : ['file'=>'']);
            $dokumentasi_profil_usaha_legalitas_npwp  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['legalitas']['npwp']) ? $data['dokumentasi_profil_usaha']['legalitas']['npwp'] : ['file'=>'']);
            $dokumentasi_profil_usaha_legalitas_nib  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['legalitas']['nib']) ? $data['dokumentasi_profil_usaha']['legalitas']['nib'] : ['file'=>'']);
            $dokumentasi_profil_usaha_legalitas_lainya  = (isset($data['dokumentasi_profil_usaha'])&&isset($data['dokumentasi_profil_usaha']['legalitas']['lainya']) ? $data['dokumentasi_profil_usaha']['legalitas']['lainya'] : []);
            $dokumentasi_profil_usaha_legalitas_lainya_files = '';
            foreach($dokumentasi_profil_usaha_legalitas_lainya as $lainya){
                $dokumentasi_profil_usaha_legalitas_lainya_files .= asset($lainya['file']) . "\n";
            }

            $profil_pengelolaan_usaha    = (isset($data['profil_pengelolaan_usaha'])&&$data['profil_pengelolaan_usaha'] ? $data['profil_pengelolaan_usaha'] : '');

            $kemampuan_finansial    = (isset($data['kemampuan_finansial'])&&$data['kemampuan_finansial'] ? $data['kemampuan_finansial'] : '');
            $kemampuan_finansial_dana_produksi = (isset($kemampuan_finansial['dana_produksi'])?$kemampuan_finansial['dana_produksi']:'');
            $kemampuan_finansial_sumber_dana_untuk_produksi = '';
            if(isset($kemampuan_finansial['sumber_dana_untuk_produksi'])&&count($kemampuan_finansial['sumber_dana_untuk_produksi'])){
                foreach ($kemampuan_finansial['sumber_dana_untuk_produksi'] as $sumber_dana_untuk_produksi) {
                    if($sumber_dana_untuk_produksi == 'Lainnya'){
                        $kemampuan_finansial_sumber_dana_untuk_produksi .= $sumber_dana_untuk_produksi .": ". (isset($kemampuan_finansial['sumber_dana_untuk_produksi_lainnya'])?$kemampuan_finansial['sumber_dana_untuk_produksi_lainnya']:'') .";\n";
                    }else{
                        $kemampuan_finansial_sumber_dana_untuk_produksi .= $sumber_dana_untuk_produksi .";\n";
                    }
                }
            }
            $kemampuan_finansial_kapasitas_pengelolaan_keuangan = implode(";\n", (isset($kemampuan_finansial['kapasitas_pengelolaan_keuangan'])?$kemampuan_finansial['kapasitas_pengelolaan_keuangan']:[]) );

            if ($profil_usaha && isset($profil_usaha['kbli']) && count($profil_usaha['kbli'])){
                $get_kbli = KbliModel::whereIn('id', $profil_usaha['kbli'])->cursor();
                foreach ($get_kbli as $kbli) {
                    array_push($kblis, "[{$kbli->code}] {$kbli->name}");
                }
            }else{
                foreach ($row->umkm->kbli as $kbli) {
                    array_push($kblis, "[{$kbli->code}] {$kbli->name}");
                }
            }

            return [
                carbonParseTransFormat($survey_result->created_at, 'd/m/Y H:i'),
                (isset($profil_usaha['nama_usaha']) ? $profil_usaha['nama_usaha'] : ''),
                (isset($profil_usaha['bentuk_badan_hukum']) ? ($profil_usaha['bentuk_badan_hukum']!='Lainnya'?$profil_usaha['bentuk_badan_hukum']:'Lainnya: '.$profil_usaha['bentuk_badan_hukum_lainnya']) : ''),
                (isset($profil_usaha['bidang_usaha']) ? $profil_usaha['bidang_usaha'] : ''),
                (isset($profil_usaha['kepemilikan_nib_nomor']) ? $profil_usaha['kepemilikan_nib_nomor'] : ''),
                implode(",\n", $kblis),
                $profil_usaha_desa,
                $profil_usaha_kecamatan,
                $profil_usaha_kabupaten,
                $profil_usaha_provinsi,
                $profil_usaha_negara,
                nl2br(isset($profil_usaha['alamat']) ? $profil_usaha['alamat'] : ''),
                (isset($profil_usaha['kode_pos']) ? $profil_usaha['kode_pos'] : ''),
                (isset($profil_usaha['koordinat_gps_longitude']) ? $profil_usaha['koordinat_gps_longitude'] : ''),
                (isset($profil_usaha['koordinat_gps_latitude']) ? $profil_usaha['koordinat_gps_latitude'] : ''),
                (isset($profil_usaha['telepon']) ? $profil_usaha['telepon'] : ''),
                (isset($profil_usaha['fax']) ? $profil_usaha['fax'] : ''),
                (isset($profil_usaha['ponsel']) ? $profil_usaha['ponsel'] : ''),
                (isset($profil_usaha['email']) ? $profil_usaha['email'] : ''),
                (isset($profil_usaha['website']) ? $profil_usaha['website'] : ''),
                (isset($profil_usaha['facebook']) ? $profil_usaha['facebook'] : ''),
                (isset($profil_usaha['instagram']) ? $profil_usaha['instagram'] : ''),
                (isset($profil_usaha['twitter']) ? $profil_usaha['twitter'] : ''),
                (isset($profil_usaha['linkedin']) ? $profil_usaha['linkedin'] : ''),
                (isset($profil_usaha['nama_cp']) ? $profil_usaha['nama_cp'] : ''),
                (isset($profil_usaha['email_cp']) ? $profil_usaha['email_cp'] : ''),
                (isset($profil_usaha['telepon_cp']) ? $profil_usaha['telepon_cp'] : ''),
                (isset($profil_usaha['fax_cp']) ? $profil_usaha['fax_cp'] : ''),
                (isset($profil_usaha['ponsel_cp']) ? $profil_usaha['ponsel_cp'] : ''),
                (isset($profil_usaha['modal_usaha']) ? str_replace([',','.'], '', $profil_usaha['modal_usaha']) : '0'),
                (isset($profil_usaha['jumlah_tenaga_kerja_laki_laki']) ? $profil_usaha['jumlah_tenaga_kerja_laki_laki'] : ''),
                (isset($profil_usaha['jumlah_tenaga_kerja_perempuan']) ? $profil_usaha['jumlah_tenaga_kerja_perempuan'] : ''),
                (isset($profil_usaha['keanggotaan_asosiasi']) ? $profil_usaha['keanggotaan_asosiasi'] : ''),

                $dokumentasi_profil_usaha_penghargaan_files,

                (!empty($dokumentasi_profil_usaha_sertifikasi_mutu['file']) ? asset($dokumentasi_profil_usaha_sertifikasi_mutu['file']) : ''),
                (!empty($dokumentasi_profil_usaha_sertifikasi_halal['file']) ? asset($dokumentasi_profil_usaha_sertifikasi_halal['file']) : ''),
                $dokumentasi_profil_usaha_sertifikasi_lainya_files,

                (!empty($dokumentasi_profil_usaha_legalitas_siup['file']) ? asset($dokumentasi_profil_usaha_legalitas_siup['file']) : ''),
                (!empty($dokumentasi_profil_usaha_legalitas_tdp['file']) ? asset($dokumentasi_profil_usaha_legalitas_tdp['file']) : ''),
                (!empty($dokumentasi_profil_usaha_legalitas_npwp['file']) ? asset($dokumentasi_profil_usaha_legalitas_npwp['file']) : ''),
                (!empty($dokumentasi_profil_usaha_legalitas_nib['file']) ? asset($dokumentasi_profil_usaha_legalitas_nib['file']) : ''),
                $dokumentasi_profil_usaha_legalitas_lainya_files,

                (isset($profil_pengelolaan_usaha['kepemilikan'])? ($profil_pengelolaan_usaha['kepemilikan']!='Lainnya'?$profil_pengelolaan_usaha['kepemilikan']: 'Lainnya: '.$profil_pengelolaan_usaha['kepemilikan_lainnya']):''),
                (isset($profil_pengelolaan_usaha['tahun_berdiri'])?$profil_pengelolaan_usaha['tahun_berdiri']:''),
                (isset($profil_pengelolaan_usaha['usia'])?$profil_pengelolaan_usaha['usia']:''),
                (isset($profil_pengelolaan_usaha['omzet']) ? ($profil_pengelolaan_usaha['omzet']!='Sebutkan'?$profil_pengelolaan_usaha['omzet']:$profil_pengelolaan_usaha['omzet_sebutkan']) :''),

                $kemampuan_finansial_dana_produksi,
                $kemampuan_finansial_sumber_dana_untuk_produksi,
                $kemampuan_finansial_kapasitas_pengelolaan_keuangan,

                (isset($responden['dibuat_di']) ? $responden['dibuat_di'] : ''),
                (isset($responden['tanggal']) ? carbonParseTransFormat($responden['tanggal'], 'd-m-Y') : ''),
                (isset($responden['nama_responden']) ? $responden['nama_responden'] : ''),
                (isset($responden['jabatan']) ? $responden['jabatan'] : ''),
                (isset($responden['nomor_ponsel']) ? $responden['nomor_ponsel'] : ''),
                (isset($responden['email']) ? $responden['email'] : ''),
                trans("label.survey_status_{$row->status}"),
                ($surveyor ? $surveyor->name : ''),
                ($surveyor ? $surveyor->email : ''),
                ($surveyor ? $surveyor->mobile_phone : ''),
                ($surveyor&&$surveyor->provinsi ? $surveyor->provinsi->nama_provinsi : ''),
                ($surveyor&&$surveyor->kabupaten ? $surveyor->kabupaten->nama_kabupaten : ''),
                ($surveyor&&$surveyor->kecamatan ? $surveyor->kecamatan->nama_kecamatan : ''),
                ($surveyor&&$surveyor->desa ? $surveyor->desa->nama_desa : ''),
                ($surveyor ? $surveyor->address : '')
            ];
        }else{
            $kblis = [];
            foreach ($row->umkm->kbli as $kbli) {
                array_push($kblis, "[{$kbli->code}] {$kbli->name}");
            }
            return [
                '',
                $row->umkm->name,
                '',
                '',
                $row->umkm->nib,
                implode(",\n", $kblis),
                ($row->umkm->desa ? $row->umkm->desa->nama_desa : ''),
                ($row->umkm->kecamatan ? $row->umkm->kecamatan->nama_kecamatan : ''),
                ($row->umkm->kabupaten ? $row->umkm->kabupaten->nama_kabupaten : ''),
                ($row->umkm->provinsi ? $row->umkm->provinsi->nama_provinsi : ''),
                ($row->umkm->negara ? $row->umkm->negara->nama_negara : ''),
                nl2br($row->umkm->address),
                $row->umkm->postal_code,
                $row->umkm->longitude,
                $row->umkm->latitude,
                $row->umkm->telp,
                $row->umkm->fax,
                '',
                $row->umkm->email,
                '',
                '',
                '',
                '',
                '',
                $row->umkm->name_pic,
                $row->umkm->email_pic,
                '',
                '',
                $row->umkm->phone_pic,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                trans("label.survey_status_{$row->status}"),
                ($surveyor ? $surveyor->name : ''),
                ($surveyor ? $surveyor->email : ''),
                ($surveyor ? $surveyor->mobile_phone : ''),
                ($surveyor&&$surveyor->provinsi ? $surveyor->provinsi->nama_provinsi : ''),
                ($surveyor&&$surveyor->kabupaten ? $surveyor->kabupaten->nama_kabupaten : ''),
                ($surveyor&&$surveyor->kecamatan ? $surveyor->kecamatan->nama_kecamatan : ''),
                ($surveyor&&$surveyor->desa ? $surveyor->desa->nama_desa : ''),
                ($surveyor ? $surveyor->address : '')
            ];
        }
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            "Waktu Survey (Tgl/Bulan/Thn; Jam)", //done
            "Nama Usaha", //done
            "Bentuk Badan Hukum", //done
            "Bidang Usaha", //done
            "NIB (Nomor Induk Berusaha)", //done
            "KBLI Usaha",
            "Kelurahan", //done
            "Kecamatan", //done
            "Kabupaten/Kota", //done
            "Provinsi", //done
            "Negara", //done
            "Alamat", //done
            "Kode Pos", //done
            "Koordinat GPS Longitude", //done
            "Koordinat GPS Latitude", //done
            "Nomor Telepon", //done
            "Nomor Fax", //done
            "Nomor Ponsel", //done
            "Email", //done
            "Website", //done
            "Facebook", //done
            "Instagram", //done
            "Twitter", //done
            "LinkedIn", //done
            "Nama Kontak Person", //done
            "Email Kontak Person", //done
            "Telepon Kontak Person", //done
            "Fax Kontak Person", //done
            "Ponsel Kontak Person", //done
            "Modal Awal", //done
            "Jumlah Tenaga Kerja Laki-laki", //done
            "Jumlah Tenaga Kerja Perempuan", //done
            "Keanggotaan Asosiasi", //done
            "Penghargaan (Award)", //done
            "Sertifikasi Mutu", //done
            "Sertifikasi Halal", //done
            "Sertifikasi Lainnya", //done
            "Legalitas SIUP", //done
            "Legalitas TDP", //done
            "Legalitas NPWP", //done
            "Legalitas NIB", //done
            "Legalitas Lainnya", //done
            "Pengelolaan Usaha", //done
            "Tahun Pendirian Usaha", //done
            "Usia (thn) Usaha", //done
            "Hasil Penjualan (Omzet) per-Tahun", //done
            "Ketersediaan dana untuk berproduksi", //done
            "Sumber dana yang pernah digunakan untuk berproduksi", //done
            "Kapasitas Pengelolaan Keuangan", //done
            "DIBUAT DI",
            "TANGGAL",
            "Nama Responden",
            "Jabatan Responden",
            "Nomor Ponsel Responden",
            "Email Responden",
            trans('label.status'),
            'Nama Surveyor',
            'Email Surveyor',
            'Phone Surveyor',
            'Provinsi Surveyor',
            'Kabupaten Surveyor',
            'Kecamatan Surveyor',
            'Desa Surveyor',
            'Alamat Surveyor',
        ];
    }

    public function title(): string
    {
        // TODO: Implement title() method.
        return "Survey-UMKM-" . Carbon::now()->format('dmYHis');
    }
}
