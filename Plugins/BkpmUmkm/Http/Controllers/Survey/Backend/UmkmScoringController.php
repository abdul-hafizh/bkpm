<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Survey\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Plugins\BkpmUmkm\DataTables\Survey\UmkmScoringDataTable;
use Plugins\BkpmUmkm\DataTables\Survey\UmkmVerifiedDataTable;
use Plugins\BkpmUmkm\Http\Requests\ScoringRequest;
use Plugins\BkpmUmkm\Models\SurveyModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UmkmScoringController extends Controller
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

    public function index(UmkmScoringDataTable $umkmScoringDataTable)
    {
        $params['title'] = trans('label.umkm_scoring');
        $params['category_company'] = $this->company_category;
        $params['show_download']    = false;
        $view = "{$this->identifier}::survey.backend.index";

        /*$inModal = request()->get('in-modal');
        if ($inModal && encrypt_decrypt($inModal, 2)=='modal'){
            $view = "{$this->identifier}::modal.datatable";
        }*/
        return $umkmScoringDataTable->render($view, $params);
    }

    public function save_update(ScoringRequest $request, $survey)
    {
        if ($request->ajax()){
            $survey_id = encrypt_decrypt($survey, 1);
            $survey = SurveyModel::where('id', $survey_id)->with(['survey_result', 'umkm'])->first();
            if ($request->get('in_modal')){
                $params['survey'] = $survey;
                $params['company']  = CATEGORY_UMKM;
                return view("{$this->identifier}::survey.backend.modal.input_scoring")->with($params);
            }
            $logProperties = [
                'attributes' => [],
                'old' => $survey->toArray()
            ];

            $survey->scoring = trim($request->input('scoring'));
            $survey->save();

            $message = 'Input scoring <strong>'. $survey->umkm->name .'</strong> = <b>'. $survey->scoring .'</b>';

            activity_log("LOG_SURVEY_SCORING", 'survey_input_scoring', $message, $logProperties, $survey);
            return responseSuccess(responseMessage('Success'));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

}
