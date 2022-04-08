<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Survey\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Survey\CompanyBersediaDataTable;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyBersediaController extends Controller
{
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_COMPANY;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->companyService = app(\Plugins\BkpmUmkm\Services\CompanyService::class);
        $this->user = auth()->user();
    }

    public function index(CompanyBersediaDataTable $companyBersediaDataTable)
    {
        $params['title'] = trans('label.index_company_bersedia');
        $params['category_company'] = $this->company_category;
        $params['show_download'] = false;
        return $companyBersediaDataTable->render($this->identifier . '::survey.backend.index', $params);
    }

}
