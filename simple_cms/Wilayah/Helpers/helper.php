<?php

if ( ! function_exists('all_negara') )
{
    function all_negara($toArray = false)
    {
        $negara = \SimpleCMS\Wilayah\Models\NegaraModel::orderBy('nama_negara', 'ASC')->where('kode_negara', 360)->cursor();
        if ($toArray){
            return $negara->toArray();
        }
        return $negara;
    }
}

if ( ! function_exists('template_wilayah') )
{
    /*
     * @param string $id_provinsi
     * @param string $id_kabupaten
     * @param string $id_kecamatan
     * @param string $id_desa
     * @param string $key_name
     * @param array $params
     * @return string|View
     * */
    /*function template_wilayah($id_provinsi = '', $id_kabupaten = '', $id_kecamatan = '', $id_desa = '', $key_name = '', $params = [])
    {
        $params = array_merge(['provinsi_required' => true, 'kabupaten_required' => false, 'kecamatan_required' => false, 'desa_required' => false], $params);

        $params['id_provinsi']  = $id_provinsi;
        $params['id_kabupaten'] = $id_kabupaten;
        $params['id_kecamatan'] = $id_kecamatan;
        $params['id_desa']      = $id_desa;
        $params['key_name']     = $key_name;

        if (!empty($key_name)){
            $params['key_name'] = '_' . $key_name;
        }

        $params['key'] = \Str::random(5);
        $params['provinsi'] = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', '<>', '350000')->orderBy('nama_provinsi', 'ASC')->cursor();
        return view('wilayah::template_wilayah')->with($params);
    }*/
}

if ( ! function_exists('template_wilayah_negara') )
{
    /*
     * @param string $id_negara
     * @param string $id_provinsi
     * @param string $id_kabupaten
     * @param string $id_kecamatan
     * @param string $id_desa
     * @param string $key_name
     * @param array $params
     * @return string|View
     * */
    function template_wilayah_negara($id_negara = '', $id_provinsi = '', $id_kabupaten = '', $id_kecamatan = '', $id_desa = '', $key_name = '', $params = [])
    {
        \Core::asset()->add('event-wilayah-js', module_asset('wilayah', 'js/event-wilayah.js'));
        \Theme::asset()->usePath(false)->add('event-wilayah-js', module_asset('wilayah', 'js/event-wilayah.js'));
        $config = app('config')->get('wilayah');
        $params = array_merge($config['wilayah_required'], $params);

        $params['id_negara']    = $id_negara;
        $params['id_provinsi']  = $id_provinsi;
        $params['id_kabupaten'] = $id_kabupaten;
        $params['id_kecamatan'] = $id_kecamatan;
        $params['id_desa']      = $id_desa;
        $params['key_name']     = $key_name;

        if (!empty($key_name)){
            $params['key_name'] = '_' . $key_name;
        }

        $params['key'] = \Str::random(5);
        $params['negara'] = all_negara();
        return view('wilayah::template_wilayah_negara')->with($params);
    }
}

if ( ! function_exists('template_wilayah_negara_provinsi_all') )
{
    /*
     * @param string $id_negara
     * @param string $id_provinsi
     * @param string $id_kabupaten
     * @param string $id_kecamatan
     * @param string $id_desa
     * @param string $key_name
     * @param array $params
     * @return string|View
     * */
    function template_wilayah_negara_provinsi_all($id_negara = '', $id_provinsi = '', $id_kabupaten = '', $id_kecamatan = '', $id_desa = '', $key_name = '', $params = [])
    {
        \Core::asset()->add('event-wilayah-all-js', module_asset('wilayah', 'js/event-wilayah-all.js'));
        \Theme::asset()->usePath(false)->add('event-wilayah-all-js', module_asset('wilayah', 'js/event-wilayah-all.js'));
        $config = app('config')->get('wilayah');
        $params = array_merge($config['wilayah_required'], $params);

        $params['id_negara']    = $id_negara;
        $params['id_provinsi']  = $id_provinsi;
        $params['id_kabupaten'] = $id_kabupaten;
        $params['id_kecamatan'] = $id_kecamatan;
        $params['id_desa']      = $id_desa;
        $params['key_name']     = $key_name;

        if (!empty($key_name)){
            $params['key_name'] = '_' . $key_name;
        }

        $params['key'] = \Str::random(5);
        $params['negara'] = all_negara();
        return view('wilayah::template_wilayah_negara')->with($params);
    }
}
