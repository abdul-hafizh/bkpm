<?php

namespace Plugins\BkpmUmkm\Services;


use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\SurveyUmkmMassiveModel;
use Plugins\BkpmUmkm\Models\UmkmMassiveModel;

class SurveyUmkmMassiveService
{

    public function survey_massive_save_update($request)
    {
        $path_upload ='';
        $path_upload_default_umkm = '';
        \DB::beginTransaction();
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $id_umkm_massive = filter($request->input('id_umkm_massive'));
            $date_survey     = filter($request->input('date_survey'));

            $umkm = UmkmMassiveModel::where('id', $id_umkm_massive)->first();
            if (empty($umkm->path)){
                $slug                       = \Str::slug($umkm->name, '-');
                $path_upload_default_umkm   = create_path_default($slug, public_path("companies/umkm-massive"));
                $umkm->path                 = $path_upload_default_umkm;
                $umkm->save();
            }

            $path_upload = $umkm->path . '/surveys';

            $logProperties = [
                'attributes' => [],
                'old' => ($id ? SurveyUmkmMassiveModel::where(['id' => $id])->first()->toArray() : [])
            ];

            $message = ($id ? 'Edit' : 'Add') . ' ' . trans('label.survey_umkm_observasi_massive') . ': ' . $umkm->name;
            $logProperties['attributes'] = $umkm->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }

            $data = [
                'id_umkm_massive' => $id_umkm_massive,
                'created_at' => (!empty($date_survey) ? carbonParseTransFormat($date_survey, 'Y-m-d H:i:s') : NULL),
                'latitude' => trim($request->input('latitude')),
                'longitude' => trim($request->input('longitude')),
                'nama_surveyor' => filter($request->input('nama_surveyor')),
                'phone_surveyor' => filter($request->input('phone_surveyor')),
                'address_surveyor' => filter($request->input('address_surveyor')),
                'keterangan' => filter($request->input('keterangan')),
                'foto_berita_acara' => ($request->input('foto_berita_acara') ? $request->input('foto_berita_acara') : []),
                'foto_legalitas_usaha' => ($request->input('foto_legalitas_usaha') ? $request->input('foto_legalitas_usaha') : []),
                'foto_tempat_usaha' => ($request->input('foto_tempat_usaha') ? $request->input('foto_tempat_usaha') : []),
                'foto_produk' => ($request->input('foto_produk') ? $request->input('foto_produk') : []),
            ];

            if ($request->has('id_negara') && $request->input('id_negara')) {
                $data['id_negara_surveyor'] = filter($request->input('id_negara'));
            }
            if ($request->has('id_provinsi') && $request->input('id_provinsi')) {
                $data['id_provinsi_surveyor'] = filter($request->input('id_provinsi'));
                $get_provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $data['id_provinsi_surveyor'])->first();
                if ($get_provinsi){
                    $data['nama_provinsi_surveyor']  = $get_provinsi->nama_provinsi;
                }
            }
            if ($request->has('id_kabupaten') && $request->input('id_kabupaten')) {
                $data['id_kabupaten_surveyor'] = filter($request->input('id_kabupaten'));
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $data['id_kabupaten_surveyor'])->first();
                if ($get_kabupaten) {
                    $data['nama_kabupaten_surveyor'] = $get_kabupaten->nama_kabupaten;
                }
            }
            if ($request->has('id_kecamatan') && $request->input('id_kecamatan')) {
                $data['id_kecamatan_surveyor'] = filter($request->input('id_kecamatan'));
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $data['id_kecamatan_surveyor'])->first();
                if ($get_kecamatan) {
                    $data['nama_kecamatan_surveyor'] = $get_kecamatan->nama_kecamatan;
                }
            }
            if ($request->has('id_desa') && $request->input('id_desa')) {
                $data['id_desa_surveyor'] = filter($request->input('id_desa'));
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $data['id_desa_surveyor'])->first();
                if ($get_desa) {
                    $data['nama_desa_surveyor'] = $get_desa->nama_desa;
                }
            }

            $data = $this->upload_input_survey($request, $data, $path_upload);

            $is_upload = false;
            if ($request->get('upload') && filter($request->get('upload')) == "dropzone"){
                $is_upload = true;
                $message = 'Upload dokumen';
            }

            $is_delete = false;
            /* Deleting */
            if($request->get('delete') && filter($request->get('delete')) == 'file_upload'){
                $message = 'Hapus dokumen';
                $is_delete = true;
                $file_delete = trim($request->input('file_delete'));
                $data_index = trim($request->input('data_index'));
                $get_data = \Arr::get($data, $data_index);

                if (is_array($get_data)){
                    $searchFile = \Arr::where($get_data, function ($value, $key) use ($file_delete) {
                        return ($value == $file_delete);
                    });
                    if ($searchFile && count($searchFile)){
                        if (file_exists(public_path($file_delete))){
                            unlink(public_path($file_delete));
                        }
                        $dotArray = key($searchFile);
                        $data_index .= '.' . $dotArray;
                        \Arr::forget($data, $data_index);
                    }
                }else{
                    if ($get_data){
                        if (file_exists(public_path($file_delete))){
                            unlink(public_path($file_delete));
                        }
                        \Arr::forget($data, $data_index);
                    }
                }
                unset($data['file_delete']);
            }
            unset($data['data_index']);

            /* inject data from umkm massive to survey umkm massive */

            if (!$is_upload && !$is_delete){
                if ($umkm->kbli) {
                    $data['desc_kbli_umkm'] = $umkm->kbli->name;
                }
                if ($umkm->nib) {
                    $data['nib_umkm'] = $umkm->nib;
                }
                if ($umkm->sector) {
                    $data['sector_umkm'] = $umkm->sector;
                }
                if ($umkm->name) {
                    $data['name_umkm'] = $umkm->name;
                }
                if ($umkm->id_negara) {
                    $data['id_negara_umkm'] = $umkm->id_negara;
                }
                if ($umkm->id_provinsi) {
                    $data['id_provinsi_umkm'] = $umkm->id_provinsi;
                    $get_provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $data['id_provinsi_umkm'])->first();
                    if ($get_provinsi){
                        $data['nama_provinsi_umkm']  = $get_provinsi->nama_provinsi;
                    }
                }
                if ($umkm->id_kabupaten) {
                    $data['id_kabupaten_umkm'] = $umkm->id_kabupaten;
                    $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $data['id_kabupaten_umkm'])->first();
                    if ($get_kabupaten) {
                        $data['nama_kabupaten_umkm'] = $get_kabupaten->nama_kabupaten;
                    }
                }
                if ($umkm->id_kecamatan) {
                    $data['id_kecamatan_umkm'] = $umkm->id_kecamatan;
                    $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $data['id_kecamatan_umkm'])->first();
                    if ($get_kecamatan) {
                        $data['nama_kecamatan_umkm'] = $get_kecamatan->nama_kecamatan;
                    }
                }
                if ($umkm->id_desa) {
                    $data['id_desa_umkm'] = $umkm->id_desa;
                    $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $data['id_desa_umkm'])->first();
                    if ($get_desa) {
                        $data['nama_desa_umkm'] = $get_desa->nama_desa;
                    }
                }
                if ($umkm->address) {
                    $data['address_umkm'] = $umkm->address;
                }
                if ($umkm->name_director) {
                    $data['name_director_umkm'] = $umkm->name_director;
                }
                if ($umkm->phone_director) {
                    $data['phone_director_umkm'] = $umkm->phone_director;
                }
            }

            $survey = SurveyUmkmMassiveModel::query()->updateOrCreate(['id' => $id], $data);

            activity_log("LOG_SURVEY_UMKM_MASSIVE", $activity_group, $message, $logProperties, $umkm);

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.umkm.survey_massive.index')];

            /* uploading */
            if($is_upload){
                $data_index = trim($request->input('data_index'));
                $get_data = \Arr::get($data, $data_index);
                $returnData = [
                    'file' => $get_data,
                    'id_form' => encrypt_decrypt($survey->id),
                    'change_url' => route('simple_cms.plugins.bkpmumkm.backend.umkm.survey_massive.edit', encrypt_decrypt($survey->id))
                ];
            }

            if ($is_delete){
                $returnData = [];
            }

            \DB::commit();
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            if($path_upload && is_dir($path_upload)){
                deleteTreeFolder($path_upload);
            }
            if($path_upload_default_umkm && is_dir($path_upload_default_umkm)){
                deleteTreeFolder($path_upload_default_umkm);
            }
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function survey_massive_restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = SurveyUmkmMassiveModel::withTrashed()->where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_SURVEY_UMKM_MASSIVE", 'restore', 'Restore '.trans('label.survey_umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);

            $umkm->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function survey_massive_soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = SurveyUmkmMassiveModel::where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_SURVEY_UMKM_MASSIVE", 'soft_delete', 'Trashed '.trans('label.survey_umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);
            $umkm->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function survey_massive_force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = SurveyUmkmMassiveModel::withTrashed()->where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_SURVEY_UMKM_MASSIVE", 'force_delete', 'Permanent delete '.trans('label.survey_umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);
            $umkm->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    protected function upload_input_survey($request, $data, $path_destination)
    {
        try {
            if ($request->file('foto_berita_acara_upload')) {
                if (!isset($data["foto_berita_acara"])){
                    $data["foto_berita_acara"] = [];
                }
                foreach ($request->file('foto_berita_acara_upload') as $k => $ha) {
                    array_push($data["foto_berita_acara"],
                        $this->upload_file($request, $path_destination, "foto_berita_acara_upload.{$k}")
                    );
                }
            }
            if ($request->file('foto_legalitas_usaha_upload')) {
                if (!isset($data["foto_legalitas_usaha"])){
                    $data["foto_legalitas_usaha"] = [];
                }
                foreach ($request->file('foto_legalitas_usaha_upload') as $k => $ha) {
                    array_push($data["foto_legalitas_usaha"],
                        $this->upload_file($request, $path_destination, "foto_legalitas_usaha_upload.{$k}")
                    );
                }
            }
            if ($request->file('foto_tempat_usaha_upload')) {
                if (!isset($data["foto_tempat_usaha"])){
                    $data["foto_tempat_usaha"] = [];
                }
                foreach ($request->file('foto_tempat_usaha_upload') as $k => $ha) {
                    array_push($data["foto_tempat_usaha"],
                        $this->upload_file($request, $path_destination, "foto_tempat_usaha_upload.{$k}")
                    );
                }
            }
            if ($request->file('foto_produk_upload')) {
                if (!isset($data["foto_produk"])){
                    $data["foto_produk"] = [];
                }
                foreach ($request->file('foto_produk_upload') as $k => $ha) {
                    array_push($data["foto_produk"],
                        $this->upload_file($request, $path_destination, "foto_produk_upload.{$k}")
                    );
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

    public function survey_massive_import($request)
    {
        $import = new \Plugins\BkpmUmkm\Imports\SurveyUmkmMassiveImport($request);
        $import->import($request->file('file'));

        $messages = [];
        $error_message = '';
        foreach ($import->failures() as $failure) {
            if (!isset($messages[$failure->row()]['title'])) {
                $messages[$failure->row()] = [
                    'title' => "Row[{$failure->row()}]: <strong>{$failure->values()['nama_umkm']}</strong><br/>",
                    'message'  => ''
                ];
            }
            foreach ($failure->errors() as $error) {
                $messages[$failure->row()]['message'] .= "- {$error}<br/>";
            }
        }
        foreach ($messages as $message) {
            $error_message .= $message['title'] . $message['message'] . '=================================<br/>';
        }
        \Log::error($import->errors());
        return responseSuccess(responseMessage('Success', ['html' => $error_message]));
    }
}
