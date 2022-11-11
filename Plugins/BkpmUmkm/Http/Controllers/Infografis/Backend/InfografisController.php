<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Infografis\Backend;

use Illuminate\Http\Request;
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
        $params['title'] = "Infografis";
        return view("{$this->identifier}::infografis.index")->with($params);
    }
}
