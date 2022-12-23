<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Kemitraan\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Realisasi\RealisasiDataTable;
use Plugins\BkpmUmkm\Http\Requests\KemitraanRequest;
use Plugins\BkpmUmkm\Models\KemitraanModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RealisasiController extends Controller
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

    public function index(KemitraanDataTable $kemitraanDataTable)
    {
        $params['title'] = "Realisasi Usaha Besar";
        $view = "{$this->identifier}::kemitraan.backend.index";
        $inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $kemitraanDataTable->render($view, $params);
    }

}
