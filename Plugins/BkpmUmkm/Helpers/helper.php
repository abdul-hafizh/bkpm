<?php

define('CATEGORY_COMPANY', 'company');
define('CATEGORY_UMKM', 'umkm');
define('UMKM_OBSERVASI', 0);
define('UMKM_POTENSIAL', 1);
define('GROUP_SUPER_ADMIN', 1);
define('GROUP_ADMIN', 2);
define('GROUP_INVESTOR', 3);
define('GROUP_UMKM', 4);
define('GROUP_QC_KOROP', 5);
define('GROUP_QC_KORWIL', 6);
define('GROUP_QC_KORPROV', 7);
define('GROUP_SURVEYOR', 8);
define('GROUP_TA', 9);
define('GROUP_ASS_KORWIL', 10);

if ( !function_exists('bkpmumkm_identifier') )
{
    function bkpmumkm_identifier($name='')
    {
        $identifier = app('config')->get('simple_cms.plugins.bkpmumkm.identifier');
        return $identifier . $name;
    }
}

if ( !function_exists('bkpmumkm_wilayah') )
{
    function bkpmumkm_wilayah($id_provinsi='')
    {
        $provinces = simple_cms_setting('bkpmumkm_wilayah');
        if ($provinces && $id_provinsi){
            $search = \Arr::where($provinces, function ($value, $key) use($id_provinsi) {
                return in_array($id_provinsi, $value['provinces']);
            });
            if (count($search)){
                $index = array_key_first($search);
                $search = \Arr::first($search);
                $search['id'] = $index;
                $search['index'] = $index;
                return $search;
            }
        }
        return '';
    }
}

if ( !function_exists('list_bkpmumkm_wilayah_by_user') )
{
    function list_bkpmumkm_wilayah_by_user()
    {
        $user = auth()->user();
        $reformat = [];
        switch ($user->group_id){
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $wilayah = bkpmumkm_wilayah($user->id_provinsi);
                $reformat[$wilayah['index']] = [
                    'id'        => $wilayah['index'],
                    'index'     => $wilayah['index'],
                    'name'      => $wilayah['name'],
                    'provinces' => \SimpleCMS\Wilayah\Models\ProvinsiModel::select('kode_provinsi', 'nama_provinsi')->whereIn('kode_provinsi', $wilayah['provinces'])->orderBy('nama_provinsi', 'ASC')->get()->toArray()
                ];
                break;
            case GROUP_SUPER_ADMIN:
            case GROUP_ADMIN:
                $wilayah = simple_cms_setting('bkpmumkm_wilayah');
                $reformat['all'] = [
                    'id'        => 'all',
                    'index'     => 'all',
                    'name'      => __('label.all_wilayah'),
                    'provinces' => []
                ];
                foreach ($wilayah as $k_wil => $wil) {
                    $reformat[$k_wil] = [
                        'id'        => $k_wil,
                        'index'     => $k_wil,
                        'name'      => $wil['name'],
                        'provinces' => \SimpleCMS\Wilayah\Models\ProvinsiModel::select('kode_provinsi', 'nama_provinsi')->whereIn('kode_provinsi', $wil['provinces'])->orderBy('nama_provinsi', 'ASC')->get()->toArray()
                    ];
                }
                break;

        }
        return $reformat;
    }
}

if ( !function_exists('bkpmumkm_colorbox') )
{
    function bkpmumkm_colorbox($source)
    {
        if (is_base64($source)) {
            return 'viewPdf';
        }
        $extension = get_extension($source);
        switch ($extension){
            case 'pdf':
                return 'viewPdf';
                break;
            default:
                return 'viewImage';
                break;
        }
    }
}

if ( !function_exists('parseDateImport') )
{
    /*
     * @param string|integer $date
     *
     * @return date
     * */
    function parseDateImport($date, $formatDate = 'Y-m-d')
    {
        if (is_numeric($date)) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($date);
        }
        return \Illuminate\Support\Carbon::parse($date)->format($formatDate);
    }
}

if ( !function_exists('current_periode') )
{
    /*
     * @return string Year
     * */
    function current_periode()
    {
        return \Carbon\Carbon::now()->format('Y');
    }
}

if ( !function_exists('enable_periode') )
{
    /*
     * @param date
     *
     * @return boolean
     * */
    function enable_periode($date)
    {
        return current_periode() == \Carbon\Carbon::parse($date)->format('Y');
    }
}
