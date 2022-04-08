<?php


namespace Plugins\BkpmUmkm\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\SurveyModel;
use Plugins\BkpmUmkm\Models\SurveyResultModel;

class SurveyService
{
    public function save_update($request)
    {
        \DB::beginTransaction();
        try {
            $category_company = $request->route()->parameter('company');
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $company_id = filter($request->input('company_id'));
            $surveyor_id = encrypt_decrypt(filter($request->input('surveyor_id')), 2);
            $yearNow = Carbon::now()->format('Y');

            $logProperties = [
                'attributes' => [],
                'old' => ($id ? SurveyModel::where(['id' => $id])->first()->toArray() : [])
            ];

            $survey = SurveyModel::where('company_id', $company_id)->whereYear('created_at', $yearNow)->first();
            if (!$survey){
                $survey = new SurveyModel();
            }

            $survey->company_id = $company_id;
            $survey->surveyor_id = $surveyor_id;
            $survey->estimated_date = Carbon::parse(filter($request->input('estimated_date')))->format('Y-m-d');
            $survey->save();

            /*$data = [
                'company_id' => $company_id,
                'surveyor_id' => $surveyor_id,
                'estimated_date' => Carbon::parse(filter($request->input('estimated_date')))->format('Y-m-d')
            ];
            $survey = SurveyModel::query()->updateOrCreate(['company_id' => $company_id], $data);*/

            $message = ($id ? 'Edit' : 'Add') . ' survey ' . trans("label.survey_{$category_company}");
            $logProperties['attributes'] = $survey->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }
            activity_log("LOG_SURVEY", $activity_group, $message, $logProperties, $survey);

            $returnData = ['redirect' => route("simple_cms.plugins.bkpmumkm.backend.survey.{$category_company}.index")];
            \DB::commit();
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function restore($request)
    {
        $category_company = $request->route()->parameter('company');
        $id = encrypt_decrypt($request->input('id'),2);
        $survey = SurveyModel::withTrashed()->where(['id' => $id])->first();
        if($survey) {
            activity_log("LOG_SURVEY", 'restore', 'Restore survey '.trans("label.survey_{$category_company}") ,[],$survey);
            $survey->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function soft_delete($request)
    {
        $category_company = $request->route()->parameter('company');
        $id = encrypt_decrypt($request->input('id'),2);
        $survey = SurveyModel::where(['id' => $id])->first();
        if($survey) {
            activity_log("LOG_SURVEY", 'soft_delete', 'Trashed survey '.trans("label.survey_{$category_company}"),[],$survey);
            $survey->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function force_delete($request)
    {
        $category_company = $request->route()->parameter('company');
        $id = encrypt_decrypt($request->input('id'),2);
        $survey = SurveyModel::withTrashed()->where(['id' => $id])->with([$category_company, 'surveyor', 'survey_result'])->first();
        if($survey) {
            $logProperties = [
                'attributes' => $survey->toArray(),
                'old' => []
            ];
            activity_log("LOG_SURVEY", 'force_delete', 'Permanent delete survey '.trans("label.survey_{$category_company}"),$logProperties,$survey);
            $survey->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function input_survey_save($request)
    {
        $category_company = $request->route()->parameter('company');
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $survey_result_id = $id;
        $survey_id = encrypt_decrypt(filter($request->input('survey_id')), 2);
        $company_id = encrypt_decrypt(filter($request->input('company_id')), 2);
        $hasSign = ($request->get('sign') && filter($request->get('sign')) == 'signature');
        if ($hasSign){
            $survey = SurveyModel::where(['id' => $survey_id])->first();
            $update = $survey->update([
                'signature' => trim($request->input('signature'))
            ]);
            activity_log("LOG_SURVEY", 'signature', 'Sign survey', ['attributes' => $survey->toArray(), 'old' => []], $survey);
            return responseMessage(trans('label.survey_sign_success'));
        }
        \DB::beginTransaction();
        try {
            $company_umkm = CompanyModel::where('id', $company_id)->first();
            $path_upload = $company_umkm->path;
            $path_upload .= '/surveys/'. Carbon::now()->year;

            $logProperties = [
                'attributes' => [],
                'old' => ($id ? SurveyModel::where(['id' => $survey_id])->with(['survey_result', $category_company])->first()->toArray() : [])
            ];

            $activity_group = 'add';
            $message = 'Input survey ' . trans("label.survey_{$category_company}");
            if (!empty($id)){
                $activity_group = 'edit';
                $message = 'Edit input survey ' . trans("label.survey_{$category_company}");
            }

            $data_survey_result = [
                'survey_id' => $survey_id
            ];
            if ($request->has('data') && $request->input('data')){
                $data_survey_result['data'] = $request->input('data');
            }

            $data_survey_result = $this->upload_input_survey($request, $data_survey_result, $path_upload);

            $is_upload = false;
            if ($request->get('upload') && filter($request->get('upload')) == "dropzone"){
                $is_upload = true;
                $message = 'Edit documents upload survey ' . trans("label.survey_{$category_company}");
            }

            $is_delete = false;
            /* Deleting */
            if($request->get('delete') && filter($request->get('delete')) == 'file_upload'){
                $message = 'Delete documents upload survey ' . trans("label.survey_{$category_company}");
                $is_delete = true;
                $file_delete = trim($request->input('file_delete'));
                $data_index = trim($request->input('data_index'));
                $get_data = \Arr::get($data_survey_result, $data_index);

                if (is_array($get_data)){
                    $searchFile = \Arr::where($get_data, function ($value, $key) use ($file_delete) {
                        return ($value['file'] == $file_delete);
                    });
                    if ($searchFile && count($searchFile)){
                        if (file_exists(public_path($file_delete))){
                            unlink(public_path($file_delete));
                        }
                        $dotArray = key($searchFile);
                        $data_index .= '.' . $dotArray;
                        \Arr::forget($data_survey_result, $data_index);
                    }
                }else{
                    if ($get_data){
                        if (file_exists(public_path($file_delete))){
                            unlink(public_path($file_delete));
                        }
                        $data_index = str_replace('.file', '', $data_index);
                        \Arr::forget($data_survey_result, $data_index);
                    }
                }
                unset($data_survey_result['file_delete']);
            }
            unset($data_survey_result['data_index']);

            $data_survey = [
                'status' => filter($request->input('status'))
            ];

            $survey = SurveyModel::query()->updateOrCreate(['id' => $survey_id], $data_survey);
            $survey_result = SurveyResultModel::query()->updateOrCreate(['survey_id' => $survey_id], $data_survey_result);

            $logProperties['attributes'] = $survey->with(['survey_result', $category_company])->first()->toArray();
//            $logProperties['attributes']['survey_result'] = $survey_result->toArray();

            if ($data_survey['status'] == 'verified'){
                $message = '<strong>'. trans('label.verified') .'</strong> survey ' . trans("label.survey_{$category_company}");
                $activity_group = "change_status_survey.{$data_survey['status']}";
            }

            activity_log("LOG_SURVEY", $activity_group, $message, $logProperties, $survey);

            $returnData = ['redirect' => route("simple_cms.plugins.bkpmumkm.backend.survey.{$category_company}.index")];

            /* uploading */
            if($is_upload){
                $data_index = trim($request->input('data_index'));
                $get_data = \Arr::get($data_survey_result, $data_index);
                $returnData = ['file' => $get_data];
            }

            if ($is_delete){
                $returnData = [];
            }
            \DB::commit();
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function survey_change_status($request)
    {
        \DB::beginTransaction();
        try {
            $user = auth()->user();
            $category_company = $request->route()->parameter('company');
            $survey_id = encrypt_decrypt($request->route()->parameter('survey'), 2);
            $status = encrypt_decrypt($request->route()->parameter('status'), 2);
            $company_id = encrypt_decrypt($request->get('company_id'), 2);

            $survey = SurveyModel::where(['id' => $survey_id])->with(['survey_result', $category_company])->first();
            if (!$survey){
                if (!empty($company_id)){
                    $survey = SurveyModel::updateOrCreate(['company_id' => $company_id], [
                        'company_id'    => $company_id,
                        'status'        => $status
                    ]);
                    $survey_id = $survey->id;
                }else {
                    throw new \Exception(trans('core::message.error.not_found'));
                }
            }
            if ($status == 'done' && !$survey->survey_result){
                throw new \Exception(trans('message.survey_status_cannot_change_to_done_because_no_have_survey_data'));
            }
            $logProperties = [
                'attributes' => [],
                'old' => $survey->toArray()
            ];
            SurveyModel::where('id', $survey_id)->update(['status' => $status]);

            $message = '<strong>'. $survey->{$category_company}->name .'</strong> change status from <b>'. trans("label.survey_status_{$survey->status}") .'</b> to <b>' . trans("label.survey_status_{$status}") .'</b>';

            activity_log("LOG_SURVEY", "change_status_survey.{$status}", $message, $logProperties, $survey);
            if ($request->input('message')) {
                activity_log("LOG_SURVEY_NOTE_" . Str::upper($status), "change_status_survey.{$status}", filter($request->input('message')), [], $survey);
            }

            \DB::commit();
            return responseMessage(trans("core::message.success.update"));
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public function survey_change_status_revision($request)
    {
        \DB::beginTransaction();
        try {
            $user = auth()->user();
            $category_company = $request->route()->parameter('company');
            $survey_id = encrypt_decrypt($request->route()->parameter('survey'), 2);
            $status = 'revision';
            $company_id = encrypt_decrypt($request->get('company_id'), 2);

            $survey = SurveyModel::where(['id' => $survey_id])->with(['survey_result', $category_company])->first();
            if (!$survey){
                if (!empty($company_id)){
                    $survey = SurveyModel::updateOrCreate(['company_id' => $company_id], [
                        'company_id'    => $company_id,
                        'status'        => $status
                    ]);
                    $survey_id = $survey->id;
                }else {
                    throw new \Exception(trans('core::message.error.not_found'));
                }
            }
            $logProperties = [
                'attributes' => [],
                'old' => $survey->toArray()
            ];
            SurveyModel::where('id', $survey_id)->update(['status' => $status]);

            $message = '<strong>'. $survey->{$category_company}->name .'</strong> change status from <b>'. trans("label.survey_status_{$survey->status}") .'</b> to <b>' . trans("label.survey_status_{$status}") .'</b>';

            activity_log("LOG_SURVEY", "change_status_survey.{$status}", $message, $logProperties, $survey);

            activity_log("LOG_SURVEY_NOTE_REVISION", "change_status_survey.{$status}", filter($request->input('message')), [], $survey);

            \DB::commit();
            return responseMessage(trans("core::message.success.update"));
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public function berita_acara_save($request)
    {
        \DB::beginTransaction();
        try {
            $category_company = $request->route()->parameter('company');
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $user = auth()->user();

            $returnData = ['redirect' => route("simple_cms.plugins.bkpmumkm.backend.survey.{$category_company}.index")];
            $message = '';

            if ($request->file('file') OR $request->file('photo')) {
                $survey = SurveyModel::where(['id' => $id, 'surveyor_id' => $user->id])->with(['survey_result'])->first();
                $surveyArray = $survey;
                $logProperties = [
                    'attributes' => [],
                    'old' => ($id ? $surveyArray->toArray() : [])
                ];
                $company = CompanyModel::where('id', $survey->company_id)->first();
                $path_upload = $company->path;
                $path_upload .= '/surveys/' . Carbon::now()->year . '/berita-acara';
                $upload_documents = ['file' => trim($request->input('file_old')), 'photo' => trim($request->input('photo_old'))];
                if ($request->file('file')){
                    $upload_documents['file'] = $this->upload_file($request, $path_upload, 'file');
                }
                if ($request->file('photo')){
                    $upload_documents['photo'] = $this->upload_file($request, $path_upload, 'photo');
                }
                $data['documents'] = $upload_documents;
                $survey = SurveyModel::query()->updateOrCreate(['id' => $id], [
                    'updated_at' => Carbon::now()
                ]);
                SurveyResultModel::where('survey_id', $id)->update($data);
                $message = 'Your upload <strong>Berita Acara</strong> survey ' . trans("label.survey_{$category_company}");
                $logProperties['attributes'] = $survey->toArray();
                $activity_group = 'upload_berita_acara';
                activity_log("LOG_SURVEY", $activity_group, $message, $logProperties, $survey);
                \DB::commit();
            }
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function verified_save($request)
    {
        \DB::beginTransaction();
        try {
            $category_company = $request->route()->parameter('company');
            $id = encrypt_decrypt(filter($request->route()->parameter('survey')), 2);
            $user = auth()->user();
            $survey = SurveyModel::where(['id' => $id])->with(['survey_result'])->first();
            $surveyArray = $survey;
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? $surveyArray->toArray() : [])
            ];

            $survey = SurveyModel::query()->updateOrCreate(['id' => $id], [
                'status' => 'verified'
            ]);
            $message = '<strong>'. trans('label.verified') .'</strong> survey ' . trans("label.survey_{$category_company}");
            $logProperties['attributes'] = $survey->toArray();
            $activity_group = "change_status_survey.{$survey->status}";
            activity_log("LOG_SURVEY", $activity_group, $message, $logProperties, $survey);

            $returnData = ['redirect' => route("simple_cms.plugins.bkpmumkm.backend.survey.{$category_company}.index")];
            \DB::commit();
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    protected function upload_input_survey($request, $data, $path_destination)
    {
        try {
            if ($request->file('data.dokumentasi_profil_usaha.penghargaan_upload')) {
                if (!isset($data["data"]["dokumentasi_profil_usaha"]["penghargaan"])){
                    $data["data"]["dokumentasi_profil_usaha"]["penghargaan"] = [];
                }
                foreach ($request->file('data.dokumentasi_profil_usaha.penghargaan_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_profil_usaha"]["penghargaan"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.penghargaan_upload.{$k}")
                    ]);
                }
            }
            if ($request->file('data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['sertifikasi']['mutu']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['sertifikasi']['mutu']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['sertifikasi']['mutu']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.sertifikasi.mutu_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['sertifikasi']['halal']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['sertifikasi']['halal']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['sertifikasi']['halal']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.sertifikasi.halal_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload')) {
                if (!isset($data["data"]["dokumentasi_profil_usaha"]["sertifikasi"]["lainya"])){
                    $data["data"]["dokumentasi_profil_usaha"]["sertifikasi"]["lainya"] = [];
                }
                foreach ($request->file('data.dokumentasi_profil_usaha.sertifikasi.lainya_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_profil_usaha"]["sertifikasi"]["lainya"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.sertifikasi.lainya_upload.{$k}")
                    ]);
                }
            }
            /*========================================*/
            if ($request->file('data.dokumentasi_profil_usaha.legalitas.siup_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['legalitas']['siup']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['legalitas']['siup']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['legalitas']['siup']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.legalitas.siup_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.legalitas.tdp_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['legalitas']['tdp']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['legalitas']['tdp']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['legalitas']['tdp']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.legalitas.tdp_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.legalitas.npwp_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['legalitas']['npwp']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['legalitas']['npwp']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['legalitas']['npwp']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.legalitas.npwp_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.legalitas.nib_upload.file')) {
                if (!isset($data['data']['dokumentasi_profil_usaha']['legalitas']['nib']["file"])){
                    $data['data']['dokumentasi_profil_usaha']['legalitas']['nib']["file"] = [];
                }
                $data['data']['dokumentasi_profil_usaha']['legalitas']['nib']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.legalitas.nib_upload.file");
            }
            if ($request->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload')) {
                if (!isset($data["data"]["dokumentasi_profil_usaha"]["legalitas"]["lainya"])){
                    $data["data"]["dokumentasi_profil_usaha"]["legalitas"]["lainya"] = [];
                }
                foreach ($request->file('data.dokumentasi_profil_usaha.legalitas.lainya_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_profil_usaha"]["legalitas"]["lainya"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_profil_usaha.legalitas.lainya_upload.{$k}")
                    ]);
                }
            }
            /*====================================================*/
            if ($request->file('data.dokumentasi_produk_dokumen.brosur_upload.file')) {
                if (!isset($data['data']['dokumentasi_produk_dokumen']['brosur']["file"])){
                    $data['data']['dokumentasi_produk_dokumen']['brosur']["file"] = [];
                }
                $data['data']['dokumentasi_produk_dokumen']['brosur']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_produk_dokumen.brosur_upload.file");
            }
            if ($request->file('data.dokumentasi_produk_dokumen.pamflet_upload.file')) {
                if (!isset($data['data']['dokumentasi_produk_dokumen']['pamflet']["file"])){
                    $data['data']['dokumentasi_produk_dokumen']['pamflet']["file"] = [];
                }
                $data['data']['dokumentasi_produk_dokumen']['pamflet']["file"] = $this->upload_file($request, $path_destination, "data.dokumentasi_produk_dokumen.pamflet_upload.file");
            }
            if ($request->file('data.dokumentasi_produk_dokumen.lainya_upload')) {
                if (!isset($data["data"]["dokumentasi_produk_dokumen"]["lainya"])){
                    $data["data"]["dokumentasi_produk_dokumen"]["lainya"] = [];
                }
                foreach ($request->file('data.dokumentasi_produk_dokumen.lainya_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_produk_dokumen"]["lainya"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_produk_dokumen.lainya_upload.{$k}")
                    ]);
                }
            }
            /*====================================================*/
            if ($request->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload')) {
                if (!isset($data["data"]["dokumentasi_fisik_terkait_usaha"]["tempat_usaha"])){
                    $data["data"]["dokumentasi_fisik_terkait_usaha"]["tempat_usaha"] = [];
                }
                foreach ($request->file('data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_fisik_terkait_usaha"]["tempat_usaha"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_fisik_terkait_usaha.tempat_usaha_upload.{$k}")
                    ]);
                }
            }
            if ($request->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload')) {
                if (!isset($data["data"]["dokumentasi_fisik_terkait_usaha"]["kegiatan_usaha"])){
                    $data["data"]["dokumentasi_fisik_terkait_usaha"]["kegiatan_usaha"] = [];
                }
                foreach ($request->file('data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_fisik_terkait_usaha"]["kegiatan_usaha"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_fisik_terkait_usaha.kegiatan_usaha_upload.{$k}")
                    ]);
                }
            }
            if ($request->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload')) {
                if (!isset($data["data"]["dokumentasi_fisik_terkait_usaha"]["papan_nama_usaha"])){
                    $data["data"]["dokumentasi_fisik_terkait_usaha"]["papan_nama_usaha"] = [];
                }
                foreach ($request->file('data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_fisik_terkait_usaha"]["papan_nama_usaha"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_fisik_terkait_usaha.papan_nama_usaha_upload.{$k}")
                    ]);
                }
            }
            if ($request->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload')) {
                if (!isset($data["data"]["dokumentasi_fisik_terkait_usaha"]["lainya"])){
                    $data["data"]["dokumentasi_fisik_terkait_usaha"]["lainya"] = [];
                }
                foreach ($request->file('data.dokumentasi_fisik_terkait_usaha.lainya_upload') as $k => $ha) {
                    array_push($data["data"]["dokumentasi_fisik_terkait_usaha"]["lainya"], [
                        "file" => $this->upload_file($request, $path_destination, "data.dokumentasi_fisik_terkait_usaha.lainya_upload.{$k}")
                    ]);
                }
            }
            if ($request->file('documents_upload')) {
                if (!isset($data['documents'])){
                    $data['documents'] = [];
                }
                foreach ($request->file('documents_upload') as $k => $ha) {
                    array_push($data["documents"], [
                        "file" => $this->upload_file($request, $path_destination, "documents_upload.{$k}")
                    ]);
                }
            }

            if ($request->input('data.profil_produk_barang_jasa')) {
                foreach ($request->input('data.profil_produk_barang_jasa') as $k => $ha) {
                    if ($request->file("data.profil_produk_barang_jasa.{$k}.foto_dokumen_upload")) {
                        if (!isset($data["data"]["profil_produk_barang_jasa"][$k]["foto_dokumen"])){
                            $data["data"]["profil_produk_barang_jasa"][$k]["foto_dokumen"] = [];
                        }
                        foreach ($request->file("data.profil_produk_barang_jasa.{$k}.foto_dokumen_upload") as $k1 => $ha1) {
                            array_push($data["data"]["profil_produk_barang_jasa"][$k]["foto_dokumen"], [
                                "file" => $this->upload_file($request, $path_destination, "data.profil_produk_barang_jasa.{$k}.foto_dokumen_upload.{$k1}")
                            ]);
                        }
                    }
                }
            }

            if ($request->file('data.profil_usaha.flow_chart_proses_produksi_upload')) {
                if (!isset($data["data"]["profil_usaha"]["flow_chart_proses_produksi"])){
                    $data["data"]["profil_usaha"]["flow_chart_proses_produksi"] = [];
                }
                foreach ($request->file('data.profil_usaha.flow_chart_proses_produksi_upload') as $k => $ha) {
                    array_push($data["data"]["profil_usaha"]["flow_chart_proses_produksi"], [
                        "file" => $this->upload_file($request, $path_destination, "data.profil_usaha.flow_chart_proses_produksi_upload.{$k}")
                    ]);
                }
            }

            return $data;
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    protected function upload_file($request, $path_upload, $name_input='files', $name_file='', $replace_url=true)
    {
        try{
            $files = $request->file($name_input);
            $extension = $files->getClientOriginalExtension();
            $ori_filename = $files->getClientOriginalName();
            $quick_random = str_random(8).date('His');
            if ($name_file!=''){
                $file_name = str_slug($name_file, '-') . '-' . $quick_random . '.' . $extension;
            }else {
                $file_name = str_slug(remove_extension($ori_filename), '-') . '-' . $quick_random . '.' . $extension;
            }
            $destination_upload = public_path($path_upload);
            $create_dir = \SimpleCMS\Core\Services\CoreService::createDirIfNotExists($destination_upload);

            if($files->move($destination_upload, $file_name)) {
                $file = url($path_upload . '/' . $file_name);
                $file = str_replace(url('/') . '/', '', $file);
                return $file;
            }
            throw new \ErrorException('Upload file '. $ori_filename .' gagal.');
        }catch (\Exception $e){
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }
}
