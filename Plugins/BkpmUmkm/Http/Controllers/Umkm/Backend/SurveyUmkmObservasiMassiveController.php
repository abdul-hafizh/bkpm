<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Umkm\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Umkm\SurveyUmkmObservasiMassiveDataTable;
use Plugins\BkpmUmkm\Http\Requests\SurveyUmkmObservasiMassiveSaveUpdateRequest;
use Plugins\BkpmUmkm\Http\Requests\UmkmImportRequest;
use Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SurveyUmkmObservasiMassiveController extends Controller
{
    protected $config;
    protected $identifier;
    protected $surveyUmkmMassiveService;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->surveyUmkmMassiveService = app(\Plugins\BkpmUmkm\Services\SurveyUmkmMassiveService::class);
    }

    public function index(SurveyUmkmObservasiMassiveDataTable $umkmDataTable)
    {
        $params['title'] = trans('label.survey_umkm_observasi_massive');
        return $umkmDataTable->render("{$this->identifier}::umkm.backend.survey_massive.index", $params);
    }

    public function add(Request $request)
    {
        $params['survey']         = new SurveyUmkmMassiveModel();
        $params['title']        = trans('label.add_new_survey_umkm_observasi_massive');
        return view( $this->identifier . '::umkm.backend.survey_massive.add_edit')->with($params);
    }

    public function edit(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['survey']      = SurveyUmkmMassiveModel::where(['id' => $id])->with(['umkm'])->first();
        if (!$params['survey']){
            return abort(404);
        }
        $params['title']        = trans('label.edit_survey_umkm_observasi_massive');
        return view( $this->identifier . '::umkm.backend.survey_massive.add_edit')->with($params);
    }

    public function detail(Request $request, $id)
    {
        $id = encrypt_decrypt(filter($id), 2);
        $params['umkm']      = SurveyUmkmMassiveModel::where(['id' => $id])->with(['umkm'])->first();
        if (!$params['umkm']){
            return abort(404);
        }
        $params['title']        = trans('label.survey_umkm_observasi_massive') . ": {$params['umkm']->name}";
        $params['auth_check']   = auth()->check();
        $params['template']     = view("{$this->identifier}::umkm.sections.survey_massive.detail")->with($params)->render();
        if ($request->ajax()){
            return view( $this->identifier . '::umkm.sections.survey_massive.modal_detail')->with($params)->render();
        }
        return view( $this->identifier . '::umkm.backend.survey_massive.detail')->with($params);
    }

    public function save_update(SurveyUmkmObservasiMassiveSaveUpdateRequest $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyUmkmMassiveService->survey_massive_save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyUmkmMassiveService->survey_massive_restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyUmkmMassiveService->survey_massive_soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyUmkmMassiveService->survey_massive_force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function import(UmkmImportRequest $request)
    {
        if($request->ajax()){
            return $this->surveyUmkmMassiveService->survey_massive_import($request);
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
}
