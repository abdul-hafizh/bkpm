<?php

namespace Plugins\BkpmUmkm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingController extends Controller
{
    protected $config;
    protected $identifier;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
    }

    public function index(Request $request)
    {
        $params['title']            = trans('label.bkpmumkm_setting');
        $params['provinces']        = \SimpleCMS\Wilayah\Models\ProvinsiModel::orderBy('nama_provinsi')->cursor();
        $params['bkpmumkm_wilayah'] = simple_cms_setting('bkpmumkm_wilayah', '');
        return view("{$this->identifier}::setting.index")->with($params);
    }

}
