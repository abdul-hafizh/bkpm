<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Kemitraan\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Kemitraan\FrontKemitraanDataTable;
use Plugins\BkpmUmkm\DataTables\Kemitraan\KemitraanDataTable;
use Plugins\BkpmUmkm\Http\Requests\KemitraanRequest;
use Plugins\BkpmUmkm\Models\KemitraanModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KemitraanController extends Controller
{
    protected $config;
    protected $identifier;
    protected $kemitraanService;
    protected $user;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->kemitraanService = app(\Plugins\BkpmUmkm\Services\KemitraanService::class);
        $this->user = auth()->user();
    }

    public function index(KemitraanDataTable $kemitraanDataTable)
    {
        $params['title'] = trans("label.index_kemitraan");
        $view = "{$this->identifier}::kemitraan.backend.index";
        $inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $kemitraanDataTable->render($view, $params);
    }

    public function edit(Request $request, $kemitraan_id)
    {
        $kemitraan_id = encrypt_decrypt($kemitraan_id, 2);
        $params['category_company'] = CATEGORY_COMPANY;
        $params['category_umkm'] = CATEGORY_UMKM;
        $params['kemitraan'] = KemitraanModel::where('id', $kemitraan_id)->whereIn('kemitraan.status', ['bersedia'])->first();
        if (!$params['kemitraan']){
            return abort(404);
        }
        $params['kemitraan']->with($params['category_company'], $params['category_umkm']);
        $params['title'] = trans("label.edit_kemitraan");
        return view($this->identifier . '::kemitraan.backend.edit')->with($params);
    }

    public function save(KemitraanRequest $request, $kemitraan_id)
    {
        return $this->kemitraanService->save();
    }

    public function front(FrontKemitraanDataTable $frontKemitraanDataTable)
    {
        return $frontKemitraanDataTable->render($this->identifier . '::kemitraan.frontend.datatable');
    }

}
