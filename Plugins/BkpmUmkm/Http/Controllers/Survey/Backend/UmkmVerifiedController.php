<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Survey\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Survey\UmkmVerifiedDataTable;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UmkmVerifiedController extends Controller
{
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_UMKM;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->user = auth()->user();
    }

    public function index(UmkmVerifiedDataTable $umkmVerifiedDataTable)
    {
        $params['title'] = trans('label.index_umkm_verified');
        $params['category_company'] = $this->company_category;
        $params['show_download']    = false;
        $view = "{$this->identifier}::survey.backend.index";
        $inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $umkmVerifiedDataTable->render($view, $params);
    }

}
