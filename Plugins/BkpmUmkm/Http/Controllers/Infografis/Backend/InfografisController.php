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
        $config = app('config')->get('simple_cms.plugins.bkpmumkm');   
        
        $year = $request->get('periode', \Carbon\Carbon::now()->format('Y'));        

        $sebaran_map = DB::select("SELECT * from vw_map_info");

        $berdasarkan_ub = DB::select("
            SELECT
                companies.sektor23 AS sektor,
                sum( kemitraan.nominal_investasi ) AS nilai 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . " 
            GROUP BY
                companies.sektor23
            ORDER BY nilai DESC
        ");

        $berdasarkan_sektor = DB::select("
            SELECT
                companies.sektor23 AS sektor,
                sum( kemitraan.nominal_investasi ) AS nilai 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.umkm_id 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  
            GROUP BY
                companies.sektor23
            ORDER BY nilai DESC
        ");

        $top_ub = DB::select("
            SELECT
                companies.`name` AS nama_ub,
                sum( kemitraan.nominal_investasi ) AS nilai 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  
            GROUP BY
                companies.`name` 
            ORDER BY
                sum( `kemitraan`.`nominal_investasi` ) DESC 
                LIMIT 5;
            ORDER BY nilai DESC
        ");

        $jenis_keb = DB::select("
            SELECT
                concat(
                    TBL.jasa,
                    ' :Rp. ',
                    format( TBL.nilai, 'de_DE' ),
                    ': ',
                    TBL.jum_ub,
                    ' UMKM',
                    ' :(',
                    TBL.nilai / TBL.ttl * 100,
                    ' %)' 
                ) AS jasa,
                TBL.nilai AS nilai 
            FROM
                (
                SELECT
                    companies.jenis_jasa AS jasa,
                    sum( kemitraan.nominal_investasi ) AS nilai,
                    count( 0 ) AS jum_ub,
                    (
                    SELECT
                        sum( kemitraan.nominal_investasi ) AS ttl 
                    FROM
                        kemitraan
                        JOIN companies ON companies.id = kemitraan.company_id 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS ttl 
                FROM
                    kemitraan
                    JOIN companies ON companies.id = kemitraan.company_id 
                WHERE
                    YEAR ( kemitraan.created_at ) = " . $year . "  
                GROUP BY
                companies.jenis_jasa 
                ) TBL
            ORDER BY nilai DESC
        ");

        $target_realisasi = DB::select("

            SELECT
                target_UB,
                ( SELECT count( DISTINCT ( company_id ) ) FROM kemitraan WHERE YEAR ( created_at ) = target.tahun ) AS realisasi_ub,
            IF
                (
                    ISNULL( target_UB ),
                    0,
                    ( ( SELECT count( DISTINCT ( company_id ) ) FROM kemitraan WHERE YEAR ( created_at ) = target.tahun ) / target_UB * 100 ) 
                ) AS UB_PERCENT,
                target_value AS target_realisasi,
                ( SELECT sum( nominal_investasi ) FROM kemitraan WHERE YEAR ( created_at ) = target.tahun ) AS realisasi_kemitraan,
            IF
                (
                    ISNULL( target_value ),
                    0,
                    ( ( SELECT sum( nominal_investasi ) FROM kemitraan WHERE YEAR ( created_at ) = target.tahun ) / target_value * 100 ) 
                ) AS REALISASI_PERCENT 
            FROM
                target 
            WHERE
                tahun = " . $year . " 
            LIMIT 1
        
        ");

        $dw1 = DB::select("

            SELECT
                wilayah.wilayah,
                sum( kemitraan.nominal_investasi ) AS nilai,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.company_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UB,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.umkm_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UMKM 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id
                INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  AND wilayah.wilayah = 'DW1'
            GROUP BY
                wilayah.wilayah 
            ORDER BY
                wilayah.wilayah
                
        ");

        $dw2 = DB::select("
            
            SELECT
                wilayah.wilayah,
                sum( kemitraan.nominal_investasi ) AS nilai,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.company_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UB,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.umkm_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UMKM 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id
                INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  AND wilayah.wilayah = 'DW2'
            GROUP BY
                wilayah.wilayah 
            ORDER BY
                wilayah.wilayah

        "); 

        $dw3 = DB::select("
            
            SELECT
                wilayah.wilayah,
                sum( kemitraan.nominal_investasi ) AS nilai,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.company_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UB,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.umkm_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UMKM 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id
                INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  AND wilayah.wilayah = 'DW3'
            GROUP BY
                wilayah.wilayah 
            ORDER BY
                wilayah.wilayah

        "); 

        $dw4 = DB::select("
            
            SELECT
                wilayah.wilayah,
                sum( kemitraan.nominal_investasi ) AS nilai,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.company_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UB,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.umkm_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UMKM 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id
                INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  AND wilayah.wilayah = 'DW4'
            GROUP BY
                wilayah.wilayah 
            ORDER BY
                wilayah.wilayah

        "); 

        $dw5 = DB::select("
            
            SELECT
                wilayah.wilayah,
                sum( kemitraan.nominal_investasi ) AS nilai,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.company_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UB,
                (
                SELECT
                    count( * ) 
                FROM
                    (
                    SELECT DISTINCT
                        ( kemitraan.umkm_id ) AS id,
                        wilayah.wilayah 
                    FROM
                        kemitraan
                        INNER JOIN companies ON companies.id = kemitraan.company_id
                        INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
                    WHERE
                        YEAR ( kemitraan.created_at ) = " . $year . "  
                    ) AS tbl 
                WHERE
                    tbl.wilayah = wilayah.wilayah 
                GROUP BY
                    tbl.wilayah 
                ) AS JUM_UMKM 
            FROM
                kemitraan
                INNER JOIN companies ON companies.id = kemitraan.company_id
                INNER JOIN wilayah ON wilayah.id_province = companies.id_provinsi 
            WHERE
                YEAR ( kemitraan.created_at ) = " . $year . "  AND wilayah.wilayah = 'DW5'
            GROUP BY
                wilayah.wilayah 
            ORDER BY
                wilayah.wilayah

        "); 

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

		$params['year'] = $year;
        $params['identifier'] = $config['identifier'];
        $params['lokasi'] = $hasil;

        $params['target_realisasi'] = $target_realisasi;
        $params['data_komitmen'] = $berdasarkan_ub;
        $params['data_sektor'] = $berdasarkan_sektor;
        $params['data_top_ub'] = $top_ub;
        $params['data_jenis_keb'] = $jenis_keb;

        $params['data_dw1'] = $dw1;
        $params['data_dw2'] = $dw2;
        $params['data_dw3'] = $dw3;
        $params['data_dw4'] = $dw4;
        $params['data_dw5'] = $dw5;

        $params['title'] = "Infografis";

        return view("{$this->identifier}::infografis.backend.index")->with($params);
    }
}
