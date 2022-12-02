<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Infografis\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleCMS\Core\Http\Controllers\Controller;

class InfografisController extends Controller
{
    protected $config;
    protected $identifier;
    protected $user;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->user = auth()->user();
    }

    public function index(Request $request)
    {
        $sebaran_map = DB::select("SELECT * from vw_map_info");

        $berdasarkan_ub = DB::select("SELECT * from KOMITMEN_KEMITRAAN_BERDASARKAN_UB");

        $berdasarkan_sektor = DB::select("SELECT * from KOMITMEN_KEMITRAAN_BERDASARKAN_SEKTOR_USAHA_YANG_DIMITRAKAN");

        $hasil = array();

        foreach($sebaran_map as $row){
            $hasil[]= array(
                $row->id,
                $row->nama_perusahaan,
                $row->alamat,
                $row->nama_provinsi,
                $row->nama_kabupaten,
                $row->nama_kecamatan,
                $row->wilayah,
                $row->long,
                $row->lat,
                $row->category,
                $row->survey_id
            );
        }  

        $params['lokasi'] = $hasil;
        $params['data_komitmen'] = $berdasarkan_ub;
        $params['title'] = "Infografis";
        return view("{$this->identifier}::infografis.backend.index")->with($params);
    }
}
