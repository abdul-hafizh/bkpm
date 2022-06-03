<?php

namespace Plugins\BkpmUmkm\Http\Controllers\CrossMatching\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\CrossMatching\CrossMatchingAvailableDataTable;
use Plugins\BkpmUmkm\DataTables\CrossMatching\CrossMatchingDataTable;
use Plugins\BkpmUmkm\DataTables\CrossMatching\CrossMatchingPickedDataTable;
use Plugins\BkpmUmkm\Models\CompanyModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CrossMatchingController extends Controller
{
    protected $config;
    protected $identifier;
    protected $user;
    protected $company_category = CATEGORY_COMPANY;
    protected $crossMatchingService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->crossMatchingService = app(\Plugins\BkpmUmkm\Services\CrossMatchingService::class);
        $this->user = auth()->user();
        $category_company = \request()->route()->parameter('company');
        switch ($category_company){
            case CATEGORY_COMPANY:
                $this->company_category = CATEGORY_COMPANY;
                break;
            case CATEGORY_UMKM:
                $this->company_category = CATEGORY_UMKM;
                break;
            default:
                abort(404);
                break;
        }
    }

    public function index(CrossMatchingDataTable $crossMatchingDataTable, $company)
    {
        $params['title'] = trans("label.index_cross_matching_{$this->company_category}");
        return $crossMatchingDataTable->render($this->identifier . '::cross_matching.backend.index', $params);
    }

    public function edit(Request $request, $company, $company_id)
    {
        $company_id = encrypt_decrypt($company_id, 2);
        $params['category_company'] = $company;
        $params['periode'] = '2022';//Carbon::now()->format('Y');
        $params['company']          = CompanyModel::where('id', $company_id);
        $year = '2022';//Carbon::now()->format('Y');
        switch ($params['category_company']){
            case CATEGORY_COMPANY:
                $params['category_reverse'] = CATEGORY_UMKM;
                $params['company']->whereHas('company_status', function($q) use($params) {
                    return $q->where('companies_status.status', 'bersedia')->whereYear('companies_status.created_at', $params['periode']);
                })->whereHas('survey', function($q) use($params) {
                    return $q->where('surveys.status', 'verified')->whereYear('surveys.created_at', $params['periode']);
                })->with(['survey' => function($q) use($params) {
                    return $q->with(['survey_result'])->where('surveys.status', 'verified')->whereYear('surveys.created_at', $params['periode']);
                }]);
                break;
            case CATEGORY_UMKM:
                $params['category_reverse'] = CATEGORY_COMPANY;
                $params['company']->whereHas('survey', function($q) use($year) {
                    return $q->where('surveys.status', 'bersedia')->whereYear('surveys.created_at', $year);
                });
                break;
        }
        $params['company'] = $params['company']->first();
        if (!$params['company']){
            return abort(404);
        }
        $params['title']            = __("label.cross_matching_{$this->company_category}_edit");
        $params['cross_matching_available'] = (new CrossMatchingAvailableDataTable())->html();
        $params['cross_matching_picked'] = (new CrossMatchingPickedDataTable())->html();
        return view($this->identifier . '::cross_matching.backend.edit')->with($params);
    }

    public function datatable_available(CrossMatchingAvailableDataTable $crossMatchingAvailableDataTable, $company, $company_id)
    {
        return $crossMatchingAvailableDataTable->render("{$this->identifier}::cross_matching.backend.datatable_available");
    }
    public function datatable_picked(CrossMatchingPickedDataTable $crossMatchingPickedDataTable, $company, $company_id)
    {
        return $crossMatchingPickedDataTable->render("{$this->identifier}::cross_matching.backend.datatable_picked");
    }

    public function picked(Request $request, $company, $company_id)
    {
        return $this->crossMatchingService->picked();
    }

    public function change_status(Request $request, $company, $company_id)
    {
        return $this->crossMatchingService->change_status();
    }
    public function force_delete(Request $request, $company, $company_id)
    {
        return $this->crossMatchingService->force_delete();
    }

}
