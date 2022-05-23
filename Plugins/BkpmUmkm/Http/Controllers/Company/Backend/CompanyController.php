<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Company\Backend;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Plugins\BkpmUmkm\DataTables\Company\CompanyDataTable;
use Plugins\BkpmUmkm\Http\Requests\CompanyChangeStatusRequest;
use Plugins\BkpmUmkm\Http\Requests\CompanyImportRequest;
use Plugins\BkpmUmkm\Http\Requests\CompanySaveUpdateRequest;
use Plugins\BkpmUmkm\Http\Requests\CompanySaveJournalRequest;
use Plugins\BkpmUmkm\Models\BusinessSectorModel;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\KbliModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyController extends Controller
{
    protected $config;
    protected $identifier;
    protected $companyService;
    protected $company_category = CATEGORY_COMPANY;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->companyService = app(\Plugins\BkpmUmkm\Services\CompanyService::class);
    }

    public function index(CompanyDataTable $companyDataTable)
    {
        $params['title'] = trans('label.index_company');
        $view = "{$this->identifier}::company.backend.index";
        $inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $companyDataTable->render($view, $params);
    }

    public function confirm_add(Request $request)
    {
        $search = filter($request->get('search'));
        $event = filter($request->get('event'));
        if ($request->ajax()&&$request->has('search')&&!empty($search)){
            return $this->confirm_search_company($request);
        }
        if ($request->ajax()&&$request->has('event')&&!empty($event)){
            switch ($event){
                case 'assign-new':
                    return responseSuccess($this->companyService->assignNewCompanyPeriode());
                    break;
            }
        }
        $params['title']        = trans('label.confirm_add_new_company');
        return view( $this->identifier . '::company.backend.confirm_add')->with($params);
    }

    public function add(Request $request)
    {
        $params['company']      = new CompanyModel();
        $params['title']        = trans('label.add_new_company');
        $params['pmdn_pma']     = $this->config['pmdn_pma'];
        return view( $this->identifier . '::company.backend.add_edit')->with($params);
    }

    public function add_journal(Request $request)
    {
        $params['user']         = auth()->user();
        $params['company']      = new CompanyModel();
        $params['title']        = 'Tambah Data Journal Perusahaan';
        $params['journal_task'] = DB::table('journal_task')->get();
        $params['companies']    = DB::table('companies')->select('id', 'name')->where('category', 'company')->orderBy('id', 'desc')->get();
        return view( $this->identifier . '::company.backend.add_edit_journal')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['company']      = CompanyModel::where(['id' => $id, 'category' => $this->company_category])->with(['sector', 'kbli'])->first();
        if (!$params['company']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_company') . ": {$params['company']->name}";;
        $params['pmdn_pma']     = $this->config['pmdn_pma'];
        return view( $this->identifier . '::company.backend.add_edit')->with($params);
    }

    public function detail(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['company']      = CompanyModel::where(['id' => $id, 'category' => $this->company_category])->first();
        if (!$params['company']){
            return abort(404);
        }
        $params['title']        = trans('label.index_company') . ": {$params['company']->name}";
        $params['auth_check']   = auth()->check();
        $params['template']     = view("{$this->identifier}::company.sections.detail")->with($params)->render();
        if ($request->ajax()){
            return view( $this->identifier . '::company.sections.modal_detail')->with($params)->render();
        }
        return view( $this->identifier . '::company.backend.detail')->with($params);
    }

    public function save_update(CompanySaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function save_journal(CompanySaveJournalRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->save_journal($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function change_status(CompanyChangeStatusRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->change_status($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->companyService->force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function import(CompanyImportRequest $request)
    {
        if($request->ajax()){
            return $this->companyService->import($request);
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    protected function confirm_search_company(Request $request)
    {
        $user = auth()->user();
        $search = filter($request->get('search'));
        $current_year = Carbon::now()->format('Y');
        $companies = CompanyModel::select(
            'companies.id',
            'companies.name',
            'companies.email',
            'companies.nib',
            'companies.id_provinsi',
            'companies.category',
            'provinsi.kode_provinsi',
            'provinsi.nama_provinsi'
        )->where(['companies.category' => $this->company_category])->leftJoin('provinsi', function($q){
            return $q->on('companies.id_provinsi', 'provinsi.kode_provinsi');
        })->with(['company_status' => function($q) use($current_year) {
            $q->whereYear('companies_status.created_at', $current_year);
        }]);

        switch ($user->group_id){
            case GROUP_QC_KORPROV:
                $companies->where('companies.id_provinsi', $user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $companies->whereIn('companies.id_provinsi', $provinces);
                break;
        }
        $companies->where(function($q) use($search) {
            $q->where('companies.name', 'LIKE', '%'. $search .'%')
                ->orWhere('companies.email', 'LIKE', '%'. $search .'%')
                ->orWhere('companies.nib', 'LIKE', '%'. $search .'%')
                ->orWhere('provinsi.nama_provinsi', 'LIKE', '%'. $search .'%');
        });
        $companies = $companies->paginate(50);
        $view = view("{$this->identifier}::company.backend.list_confirm_add", compact('companies'))->render();
        return responseSuccess(responseMessage('Success', ['html' => $view, '_token' => csrf_token()]));
    }
}
