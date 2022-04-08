<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 15/03/18
 * Time: 9:14
 */

namespace SimpleCMS\Wilayah\Services;


use SimpleCMS\Wilayah\Models\DesaModel;
use SimpleCMS\Wilayah\Models\KabupatenModel;
use SimpleCMS\Wilayah\Models\KecamatanModel;
use SimpleCMS\Wilayah\Models\ProvinsiModel;
use SimpleCMS\Wilayah\Models\NegaraModel;

class WilayahService
{
    /*public static function save($request)
    {
        \DB::beginTransaction();
        try{
            $type = filter($request->input('type'));
            $kode = 'kode_'.$type;
            $name = 'nama_'.$type;
            switch ($type){
                case 'negara':
                    NegaraModel::updateOrCreate(['kode_negara'=>filter($request->input($kode))],[
                        'kode_negara' => filter($request->input($kode)),
                        'nama_negara' => filter($request->input($name))
                    ]);
                    break;
                case 'provinsi':
                    ProvinsiModel::updateOrCreate(['kode_provinsi'=>filter($request->input($kode))],[
                        'kode_provinsi' => filter($request->input($kode)),
                        'nama_provinsi' => filter($request->input($name)),
                        'kode_negara' => filter($request->input('kode_negara'))
                    ]);
                    break;
                case 'kabupaten':
                    KabupatenModel::updateOrCreate(['kode_kabupaten'=>filter($request->input($kode))],[
                        'kode_kabupaten' => filter($request->input($kode)),
                        'nama_kabupaten' => filter($request->input($name)),
                        'kode_negara' => filter($request->input('kode_negara')),
                        'kode_provinsi' => filter($request->input('kode_provinsi'))
                    ]);
                    break;
                case 'kecamatan':
                    $kabupaten = KabupatenModel::where('kode_kabupaten','=',filter($request->input('kode_parent')))->first();
                    KecamatanModel::updateOrCreate(['kode_kecamatan'=>filter($request->input($kode))],[
                        'kode_provinsi' => $kabupaten->kode_provinsi,
                        'kode_kabupaten' => filter($request->input('kode_parent')),
                        'kode_kecamatan' => filter($request->input($kode)),
                        'nama_kecamatan' => filter($request->input($name))
                    ]);
                    break;
                case 'desa':
                    $kecamatan = KecamatanModel::where('kode_kecamatan','=',filter($request->input('kode_parent')))->first();
                    DesaModel::updateOrCreate(['kode_desa'=>filter($request->input($kode))],[
                        'kode_provinsi' => $kecamatan->kode_provinsi,
                        'kode_kabupaten' => $kecamatan->kode_kabupaten,
                        'kode_kecamatan' => filter($request->input('kode_parent')),
                        'kode_desa' => filter($request->input($kode)),
                        'nama_desa' => filter($request->input($name))
                    ]);
                    break;
            }
            \DB::commit();
            return responseMessage('Save Success.',['type'=>$type]);
        }catch (\Exception $e){
            \DB::rollback();
            throw new \ErrorException($e->getMessage());
        }
    }*/


    public static function get_ajax($request)
    {
        $user = auth()->user();
        $dataWilayah = [];
        switch (filter($request->input('to'))){
            case 'provinsi' :
                $dataWilayah = ProvinsiModel::select([
                    'kode_provinsi',
                    'nama_provinsi',
                    'kode_negara'
                ])->where('kode_negara',filter($request->input('kode'),false))->orderBy('nama_provinsi','ASC');

                if (auth()->check() && !$request->get('all')) {
                    switch ($user->group_id) {
                        case GROUP_QC_KORPROV:
                            if (!empty($user->id_provinsi)) {
                                $dataWilayah->where('kode_provinsi', $user->id_provinsi);
                            }
                            break;
                        case GROUP_QC_KORWIL:
                        case GROUP_SURVEYOR:
                        case GROUP_ASS_KORWIL:
                        // case GROUP_TA:
                            if (!empty($user->id_provinsi)) {
                                $provinces = bkpmumkm_wilayah($user->id_provinsi);
                                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                                $dataWilayah->whereIn('kode_provinsi', $provinces);
                            }
                            break;
                    }
                }
                $dataWilayah = $dataWilayah->cursor();
                break;
            case 'kabupaten' :
                $dataWilayah = KabupatenModel::select([
                    'kode_kabupaten',
                    'nama_kabupaten',
                    'is_kota',
                    'kode_provinsi',
                    'kode_negara'
                ])->where('kode_provinsi',filter($request->input('kode'),false))->orderBy('nama_kabupaten','ASC')->cursor();
                break;
            case 'kecamatan' :
                $dataWilayah = KecamatanModel::select([
                    'kode_kecamatan',
                    'nama_kecamatan',
                    'kode_kabupaten',
                    'kode_provinsi',
                    'kode_negara'
                ])->where('kode_kabupaten',filter($request->input('kode'),false))->orderBy('nama_kecamatan','ASC')->cursor();
                break;
            case 'desa' :
                $dataWilayah = DesaModel::select([
                    'kode_desa',
                    'nama_desa',
                    'kode_kecamatan',
                    'is_kelurahan',
                    'kode_kabupaten',
                    'kode_provinsi',
                    'kode_negara'
                ])->where('kode_kecamatan',filter($request->input('kode'),false))->orderBy('nama_desa','ASC')->cursor();
                break;
            default :
                $dataWilayah = NegaraModel::select([
                    'kode_negara',
                    'nama_negara',
                ])->orderBy('nama_negara','ASC')->cursor();
                break;
        }

        return responseSuccess($dataWilayah);
    }

}
