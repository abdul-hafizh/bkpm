<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Survey\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Survey\UmkmDataTable;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UmkmController extends Controller
{
    protected $config;
    protected $identifier;
    protected $companyService;
    protected $user;
    protected $company_category = CATEGORY_UMKM;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->companyService = app(\Plugins\BkpmUmkm\Services\CompanyService::class);
        $this->user = auth()->user();
    }

    public function index(UmkmDataTable $umkmDataTable)
    {
        $params['title'] = trans('label.survey_umkm');
        $params['category_company'] = $this->company_category;
        $params['show_download'] = false;
        if ($this->user->group_id == GROUP_SURVEYOR){
            $params['show_download'] = true;
        }
        $view = "{$this->identifier}::survey.backend.index";
        $inModal = request()->get('in-modal');
        $status = request()->get('status');
        $status = encrypt_decrypt($status, 2);
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal' && in_array($status, ['progress', 'done', 'menolak', 'pindah', 'tutup'])){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $umkmDataTable->render($view, $params);
    }

}
