<?php

namespace Plugins\BkpmUmkm\Http\Controllers\Survey\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\BkpmUmkm\Exports\SurveyCompanyExport;
use Plugins\BkpmUmkm\Exports\SurveyUmkmExport;
use Plugins\BkpmUmkm\Http\Requests\InputSurveySaveUpdateRequest;
use Plugins\BkpmUmkm\Http\Requests\SurveySaveUpdateRequest;
use Plugins\BkpmUmkm\Http\Requests\UploadBeritaAcaraRequest;
use Plugins\BkpmUmkm\Models\SurveyModel;
use Plugins\BkpmUmkm\Models\SurveyResultModel;
use SimpleCMS\Core\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PDF;

class SurveyController extends Controller
{
    protected $config;
    protected $identifier;
    protected $surveyService;
    protected $user;
    protected $company_category;

    public function __construct()
    {
        $this->config = app('config')->get('simple_cms.plugins.bkpmumkm');
        $this->identifier = $this->config['identifier'];
        $this->surveyService = app(\Plugins\BkpmUmkm\Services\SurveyService::class);
        $this->company_category = \request()->route()->parameter('company');
        $this->user = auth()->user();
    }

    public function add(Request $request, $company)
    {
        $params['title']            = trans("label.add_new_survey_{$company}");
        $params['category_company'] = $company;
        $params['survey']           = new SurveyModel();
        $params['surveyors']        = $this->get_surveyors();
        $params['event']            = 'add';
        return view("{$this->identifier}::survey.backend.add_edit")->with($params);
    }
    public function edit(Request $request, $company, $survey)
    {
        $survey_id = encrypt_decrypt($survey, 2);
        $params['title']            = trans("label.edit_survey_{$company}");
        $params['category_company'] = $company;
        $params['survey']           = SurveyModel::where('id', $survey_id)->first();
        if (!$params['survey']){
            return abort(404);
        }
        $params['surveyors']        = $this->get_surveyors();
        $params['event']            = 'edit';
        return view("{$this->identifier}::survey.backend.add_edit")->with($params);
    }

    public function save_update(SurveySaveUpdateRequest $request, $company)
    {
        if ($request->ajax())
        {
            return responseSuccess($this->surveyService->save_update($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function restore(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyService->restore($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function soft_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyService->soft_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }
    public function force_delete(Request $request)
    {
        if($request->ajax()){
            return responseSuccess($this->surveyService->force_delete($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function input_survey(Request $request, $company, $survey)
    {
        $survey_id = encrypt_decrypt($survey, 2);
        $params['title']            = trans("label.survey_input_survey_{$company}");
        $params['category_company'] = $company;
        $params['survey']           = SurveyModel::where(['id' => $survey_id])->with([$company, 'survey_result'])->whereHas($company);
        switch ($this->user->group_id) {
            case GROUP_SURVEYOR:
                $params['survey']->whereNotIn('status', ['verified', 'done', 'bersedia', 'menolak', 'tutup', 'pindah'])->where('surveys.surveyor_id', $this->user->id);
                break;
            default:
                $params['survey']->whereNotIn('status', ['verified', 'done', 'bersedia', 'menolak', 'tutup', 'pindah']);
                break;
        }
        $params['survey'] = $params['survey']->first();
        if (!$params['survey']){
            return abort(404);
        }
        if (!$params['survey']->survey_result){
            $params['survey']->survey_result = new SurveyResultModel();
        }
        $params['title'] .= ': '. $params['survey']->{$company}->name;
        $params['status_survey']    = $this->config['status_survey'];
        $params['negara']           = all_negara();
        $params['path_company']     = $params['survey']->{$company}->path;
        switch ($company)
        {
            case CATEGORY_COMPANY:
                $params['business_sectors'] = \Plugins\BkpmUmkm\Models\BusinessSectorModel::select('id', 'name', 'deleted_at')->orderBy('name')->cursor();
                break;
            case CATEGORY_UMKM:

                break;
        }
        return view("{$this->identifier}::survey.backend.form_survey_{$company}")->with($params);
    }

    public function detail_survey(Request $request, $company, $survey)
    {
        $survey_id = encrypt_decrypt($survey, 2);
        $params['title']            = trans("label.survey_detail_survey_{$company}");
        $params['category_company'] = $company;
        $params['survey']           = SurveyModel::where(['id' => $survey_id])->whereHas($company)->with([$company, 'surveyor', 'survey_result']);

        switch ($this->user->group_id){
            case GROUP_SURVEYOR:
                $params['survey']->where('surveys.surveyor_id', $this->user->id);
                break;
            case GROUP_QC_KORPROV:
                $params['survey']->whereHas('surveyor', function ($q){
                    $q->where('users.id_provinsi', $this->user->id_provinsi);
                });
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $params['survey']->whereHas('surveyor', function ($q) use($provinces){
                    $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                    $q->whereIn('users.id_provinsi', $provinces);
                });
                break;
            default:

                break;
        }

        $params['survey']      = $params['survey']->first();
        $params['list_photo']  = DB::table('vw_photo_survey')->where('survey_id', $survey_id)->first();

        if (!$params['survey']){
            return abort(404);
        }

        $params['title'] .= ': '. $params['survey']->{$company}->name;

        switch ($company)
        {
            case CATEGORY_COMPANY:
                $params['business_sectors'] = \Plugins\BkpmUmkm\Models\BusinessSectorModel::select('id', 'name', 'deleted_at')->orderBy('name')->cursor();
                break;
            case CATEGORY_UMKM:
                break;
        }

        if ($request->ajax()&&$request->get('in_modal')){
            return view("{$this->identifier}::survey.backend.detail_survey_modal")->with($params)->render();
        }

        return view("{$this->identifier}::survey.backend.detail_survey_{$company}")->with($params);
    }

    public function cetak_pdf(Request $request, $company, $id)
    {
		$id = encrypt_decrypt(filter($id), 2);
        $umkm = SurveyModel::where(['id' => $id])->whereHas($company)->with([$company, 'surveyor', 'survey_result'])->first();
    	$pdf = PDF::loadview($this->identifier . '::survey.backend.umkm_pdf', ['umkm' => $umkm]);
    	return $pdf->download('PROFILE_' . $umkm->{$company}->name . '_NIB:' . $umkm->{$company}->nib . '.pdf');
    }

    public function input_survey_save(InputSurveySaveUpdateRequest $request, $company, $survey)
    {
        if ($request->ajax())
        {
             return responseSuccess($this->surveyService->input_survey_save($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function survey_change_status(Request $request, $company, $survey, $status)
    {
        if ($request->ajax())
        {
            $in_modal = trim($request->get('in_modal'));
            $in_modal = ($in_modal ? encrypt_decrypt($in_modal, 2) : null);
            $params['status']   = encrypt_decrypt($status, 1);
            if ($in_modal && in_array($params['status'], ['bersedia', 'menolak', 'tutup', 'pindah'])){
                $params['survey'] = SurveyModel::where('id', encrypt_decrypt($survey, 1))->with($company)->first();
                $params['company']  = $company;
                if (!$params['survey']){
                    throw new NotFoundHttpException(trans('core::message.error.not_found'));
                }
                return view("{$this->identifier}::survey.backend.modal.change_status")->with($params);
            }
            return responseSuccess($this->surveyService->survey_change_status($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function survey_change_status_revision(Request $request, $company, $survey)
    {
        if ($request->ajax())
        {
            $in_modal = trim($request->get('in_modal'));
            $in_modal = ($in_modal ? encrypt_decrypt($in_modal, 2) : null);
            if ($in_modal == 'revision'){
                $params['survey'] = SurveyModel::where('id', encrypt_decrypt($survey, 1))->with($company)->first();
                $params['company']  = $company;
                if (!$params['survey']){
                    throw new NotFoundHttpException(trans('core::message.error.not_found'));
                }
                return view("{$this->identifier}::survey.backend.modal.change_status_revision")->with($params);
            }
            return responseSuccess($this->surveyService->survey_change_status_revision($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function berita_acara(Request $request, $company, $survey)
    {
        $survey_id = encrypt_decrypt($survey, 2);
        $params['title'] = trans('label.survey_berita_acara');
        if ($company == CATEGORY_COMPANY){
            $params['title'] = trans('label.survey_upload_documents');
        }
        $params['survey'] = SurveyModel::where(['id' => $survey_id, 'surveyor_id' => auth()->user()->id])->whereNotIn('status', ['verified'])->with(['survey_result'])->first();
        if (!$params['survey'] OR ($params['survey'] && !$params['survey']->survey_result)){
            return abort(404);
        }
        $params['category_company'] = $company;
        return view("{$this->identifier}::survey.backend.berita_acara")->with($params);
    }

    public function berita_acara_save(UploadBeritaAcaraRequest $request, $company, $survey)
    {
        if ($request->ajax())
        {
            return responseSuccess($this->surveyService->berita_acara_save($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function download_berita_acara(Request $request, $company, $survey)
    {
        $page = filter($request->get('page'));
        $survey_id = encrypt_decrypt($survey, 2);
        $params['year'] = Carbon::now()->format('Y');
        $params['category_company'] = $company;
        switch ($page){
            case 'modal':
                if ($request->ajax())
                {
                    $params['survey'] = SurveyModel::where('id', $survey_id)->with($company)->first();
                    $params['bkpmumkm_wilayah'] = bkpmumkm_wilayah($this->user->id_provinsi);
                    $params['provinsi'] = \SimpleCMS\Wilayah\Models\ProvinsiModel::select([
                        'kode_provinsi',
                        'nama_provinsi',
                        'kode_negara'
                    ])->whereIn('kode_provinsi', $params['bkpmumkm_wilayah']['provinces'])->orderBy('nama_provinsi','ASC')->cursor();
                    return view("{$this->identifier}::survey.backend.modal_berita_acara")->with($params);
                }
                break;
            case 'request-download':
                $key_session_download = 'download_berita_acara_' . \Str::random(5);
                $params['date_survey'] = filter($request->input('date_survey'));
                $params['company_name'] = filter($request->input('company_name'));
                $params['company_address'] = filter($request->input('company_address'));
                $params['nama_provinsi'] = '';
                $params['nama_kabupaten'] = '';
                $params['nama_kecamatan'] = '';
                $params['nama_desa'] = '';
                $params['province_signature'] = '';
                $params['date_signature'] = filter($request->input('date_signature'));

                $id_provinsi = filter($request->input('id_provinsi'));
                if ($id_provinsi){
                    $provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $id_provinsi)->first();
                    $params['nama_provinsi'] = $provinsi->nama_provinsi;
                }
                $id_kabupaten = filter($request->input('id_kabupaten'));
                if ($id_kabupaten){
                    $kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $id_kabupaten)->first();
                    $params['nama_kabupaten'] = $kabupaten->nama_kabupaten .', ';
                }
                $id_kecamatan = filter($request->input('id_kecamatan'));
                if ($id_kecamatan){
                    $kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $id_kecamatan)->first();
                    $params['nama_kecamatan'] = $kecamatan->nama_kecamatan .', ';
                }
                $id_desa = filter($request->input('id_desa'));
                if ($id_desa){
                    $desa = \SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $id_desa)->first();
                    $params['nama_desa'] = $desa->nama_desa .', ';
                }
                $province_signature = filter($request->input('province_signature'));
                if ($province_signature){
                    $province_signature = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $province_signature)->first();
                    $params['province_signature'] = $province_signature->nama_provinsi;
                }
                $request->session()->put($key_session_download, json_encode($params));
                return responseSuccess(responseMessage('Success', ['redirect' => route("{$this->identifier}.backend.survey.download_berita_acara", ['company' => $company, 'survey'=>encrypt_decrypt($survey_id), 'page' => 'download', 'key' => encrypt_decrypt($key_session_download)])]));
                break;
            case 'download':
                $key_session_download = encrypt_decrypt(trim($request->get('key')), 2);
                if ($request->session()->has($key_session_download)) {
                    $session_download = $request->session()->get($key_session_download);
                    $session_download = unserializeCustom($session_download);
                    unset($session_download['year']);
                    unset($session_download['category_company']);
                    $params = array_merge($params, $session_download);
                    $params['title'] = "berita-acara-{$company}-ptsi";
                    $file_name = "{$params['title']}.pdf";
                    $pdf = \PDF::loadHTML(view("{$this->identifier}::survey.backend.template_berita_acara_{$company}")->with($params)->render());
                    $request->session()->forget($key_session_download);
                    return $pdf->download($file_name);
                }
                break;
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function verified(Request $request, $company, $survey)
    {
        $survey_id = encrypt_decrypt($survey, 2);
        $params['title']            = trans("label.survey_verified_{$company}");
        $params['category_company'] = $company;
        
        $params['survey']           = SurveyModel::where(['id' => $survey_id])->where('status', 'done')->whereHas('survey_result', function ($q){
            return $q->where('survey_results.documents', '<>', '');
        })->whereHas($company)->with([$company, 'surveyor', 'survey_result']);
        $params['survey']           = $params['survey']->first();
        if (!$params['survey']){
            return abort(404);
        }
        $params['title'] .= ': '. $params['survey']->{$company}->name;
        switch ($company)
        {
            case CATEGORY_COMPANY:
                $params['business_sectors'] = \Plugins\BkpmUmkm\Models\BusinessSectorModel::select('id', 'name', 'deleted_at')->orderBy('name')->cursor();
                break;
            case CATEGORY_UMKM:

                break;
        }
        return view("{$this->identifier}::survey.backend.verified_survey")->with($params);
    }

    public function verified_save(Request $request, $company, $survey)
    {
        if ($request->ajax())
        {
            return responseSuccess($this->surveyService->verified_save($request));
        }
        throw new NotFoundHttpException(trans('core::message.error.not_found'));
    }

    public function survey_export(Request $request, $company)
    {
        $name_file_download = "survey-{$company}-export-" . date('dmYHis') . '.xlsx';
        ob_end_clean();
        ob_start();
        libxml_use_internal_errors(true);
        switch ($company){
            case CATEGORY_COMPANY:
                return (new SurveyCompanyExport)->download($name_file_download, \Maatwebsite\Excel\Excel::XLSX);
                break;
            case CATEGORY_UMKM:
                return (new SurveyUmkmExport)->download($name_file_download, \Maatwebsite\Excel\Excel::XLSX);
                break;
        }
        return abort(404);
    }

    protected function get_surveyors()
    {
        $request_company = request()->route('company');
        if ($request_company === CATEGORY_COMPANY ){
            $surveyors = \SimpleCMS\ACL\Models\User::where('users.group_id', GROUP_QC_KORWIL)->with(['provinsi']);
        }else {
            $surveyors = \SimpleCMS\ACL\Models\User::where('users.group_id', GROUP_SURVEYOR)->with(['provinsi']);
        }
        switch ($this->user->group_id){
            case GROUP_QC_KORPROV:
                $surveyors->where('users.id_provinsi', $this->user->id_provinsi);
                break;
            case GROUP_QC_KORWIL:
            case GROUP_ASS_KORWIL:
            case GROUP_TA:
                $provinces = bkpmumkm_wilayah($this->user->id_provinsi);
                $provinces = ($provinces && isset($provinces['provinces']) ? $provinces['provinces'] : []);
                $surveyors = $surveyors->whereIn('users.id_provinsi', $provinces);
                break;
        }
        return $surveyors->orderBy('users.name')->cursor();
    }

    public function _get_surveyors()
    {
        return $this->get_surveyors();
    }

}
