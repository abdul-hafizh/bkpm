<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Umkm\Backend;

use Plugins\BkpmUmkm\DataTables\Umkm\UmkmObservasiDataTable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\Http\Requests\UmkmImportRequest;
use Plugins\BkpmUmkm\Http\Requests\UmkmObservasiSaveUpdateRequest;
use Plugins\BkpmUmkm\Models\CompanyModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UmkmObservasiController extends Controller
{
    protected $config;
    protected $identifier;
    protected $umkmService;
    protected $company_category = CATEGORY_UMKM;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->umkmService = app(\Plugins\BkpmUmkm\Services\UmkmService::class);
    }

    public function index(UmkmObservasiDataTable $umkmDataTable)
    {
        $params['title'] = trans('label.umkm_observasi');
        $view = "{$this->identifier}::umkm.backend.observasi.index";
        $inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }
        return $umkmDataTable->render($view, $params);
    }

    public function add(Request $request)
    {
        $params['umkm']         = new CompanyModel();
        $params['title']        = trans('label.add_new_umkm_observasi');
        /*$params['sectors']      = BusinessSectorModel::orderBy('name')->cursor();
        $params['kbli']         = KbliModel::orderBy('name')->cursor();*/
        $params['surveyors']    = app(\Plugins\BkpmUmkm\Http\Controllers\Survey\Backend\SurveyController::class)->_get_surveyors();
        return view( $this->identifier . '::umkm.backend.observasi.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['umkm']      = CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->with(['sector', 'kbli'])->first();
        if (!$params['umkm']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_umkm_observasi');
        /*$params['sectors']      = BusinessSectorModel::orderBy('name')->cursor();
        $params['kbli']         = KbliModel::orderBy('name')->cursor();*/
        $params['surveyors']    = app(\Plugins\BkpmUmkm\Http\Controllers\Survey\Backend\SurveyController::class)->_get_surveyors();
        return view( $this->identifier . '::umkm.backend.observasi.add_edit')->with($params);
    }

    public function detail(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['umkm']      = CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->first();
        if (!$params['umkm']){
            return abort(404);
        }
        $params['title']        = trans('label.umkm_observasi') . ": {$params['umkm']->name}";
        $params['auth_check']   = auth()->check();
        $params['template']     = view("{$this->identifier}::umkm.sections.observasi.detail")->with($params)->render();
        if ($request->ajax()){
            return view( $this->identifier . '::umkm.sections.observasi.modal_detail')->with($params)->render();
        }
        return view( $this->identifier . '::umkm.backend.observasi.detail')->with($params);
    }

    public function save_update(UmkmObservasiSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmService->observasi_save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmService->observasi_restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmService->observasi_soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->umkmService->observasi_force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function import(UmkmImportRequest $request)
    {
        if($request->ajax()){
            return $this->umkmService->observasi_import($request);
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
}
