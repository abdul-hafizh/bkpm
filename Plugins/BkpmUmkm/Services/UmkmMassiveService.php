<?php


namespace Plugins\BkpmUmkm\Services;


use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\UmkmMassiveModel;

class UmkmMassiveService
{

    public function observasi_massive_save_update($request)
    {
        $path_upload ='';
        \DB::beginTransaction();
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? UmkmMassiveModel::where(['id' => $id])->first()->toArray() : [])
            ];

            $data = [
                'name' => filter($request->input('name')),
                'nib' => filter($request->input('nib')),
                'sector' => filter($request->input('sector')),
                'id_negara' => filter($request->input('id_negara')),
                'address' => filter($request->input('address')),
                'postal_code' => filter($request->input('postal_code')),
                'name_director' => filter($request->input('name_director')),
                'email_director' => \Str::lower(filter($request->input('email_director'))),
                'phone_director' => filter($request->input('phone_director')),
                'total_employees' => 0,
                'net_worth' => 0,
                'omset_every_year' => 0,
                'startup_capital' => 0
            ];
            if ($request->has('code_kbli') && $request->input('code_kbli')) {
                $data['code_kbli'] = filter($request->input('code_kbli'));
            }
            if ($request->has('id_provinsi') && $request->input('id_provinsi')) {
                $data['id_provinsi'] = filter($request->input('id_provinsi'));
                $get_provinsi = \SimpleCMS\Wilayah\Models\ProvinsiModel::where('kode_provinsi', $data['id_provinsi'])->first();
                if ($get_provinsi){
                    $data['nama_provinsi']  = $get_provinsi->nama_provinsi;
                }
            }
            if ($request->has('id_kabupaten') && $request->input('id_kabupaten')) {
                $data['id_kabupaten'] = filter($request->input('id_kabupaten'));
                $get_kabupaten = \SimpleCMS\Wilayah\Models\KabupatenModel::where('kode_kabupaten', $data['id_kabupaten'])->first();
                if ($get_kabupaten) {
                    $data['nama_kabupaten'] = $get_kabupaten->nama_kabupaten;
                }
            }
            if ($request->has('id_kecamatan') && $request->input('id_kecamatan')) {
                $data['id_kecamatan'] = filter($request->input('id_kecamatan'));
                $get_kecamatan = \SimpleCMS\Wilayah\Models\KecamatanModel::where('kode_kecamatan', $data['id_kecamatan'])->first();
                if ($get_kecamatan) {
                    $data['nama_kecamatan'] = $get_kecamatan->nama_kecamatan;
                }
            }
            if ($request->has('id_desa') && $request->input('id_desa')) {
                $data['id_desa'] = filter($request->input('id_desa'));
                $get_desa = \SimpleCMS\Wilayah\Models\DesaModel::where('kode_desa', $data['id_desa'])->first();
                if ($get_desa) {
                    $data['nama_desa'] = $get_desa->nama_desa;
                }
            }

            if ($request->has('total_employees') && $request->input('total_employees')) {
                $data['total_employees'] = filter($request->input('total_employees'));
            }
            if ($request->has('net_worth') && $request->input('net_worth')) {
                $data['net_worth'] = str_replace([',', '.'], '', filter($request->input('net_worth')));
            }
            if ($request->has('omset_every_year') && $request->input('omset_every_year')) {
                $data['omset_every_year'] = str_replace([',', '.'], '', filter($request->input('omset_every_year')));
            }
            if ($request->has('startup_capital') && $request->input('startup_capital')) {
                $data['startup_capital'] = str_replace([',', '.'], '', filter($request->input('startup_capital')));
            }

            if (empty($id) OR ($id && empty($logProperties['old']['path']))) {
                $slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/umkm-massive"));
                $data['path'] = $path_upload_default;
                $path_upload = $path_upload_default;
            }

            $umkm = UmkmMassiveModel::query()->updateOrCreate(['id' => $id], $data);
            $message = ($id ? 'Edit' : 'Add') . ' ' . trans('label.umkm_observasi_massive') . ': ' . $umkm->name;
            $logProperties['attributes'] = $umkm->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }
            activity_log("LOG_UMKM_MASSIVE", $activity_group, $message, $logProperties, $umkm);

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.umkm.massive.index')];
            \DB::commit();
            return responseMessage($message . ' success', $returnData);
        }catch (\Exception $e)
        {
            \DB::rollback();
            if($path_upload && is_dir($path_upload)){
                deleteTreeFolder($path_upload);
            }
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function observasi_massive_restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = UmkmMassiveModel::withTrashed()->where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_UMKM_MASSIVE", 'restore', 'Restore '.trans('label.umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);

            $umkm->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function observasi_massive_soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = UmkmMassiveModel::where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_UMKM_MASSIVE", 'soft_delete', 'Trashed '.trans('label.umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);
            $umkm->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function observasi_massive_force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = UmkmMassiveModel::withTrashed()->where(['id' => $id])->first();
        if($umkm) {
            activity_log("LOG_UMKM_MASSIVE", 'force_delete', 'Permanent delete '.trans('label.umkm_observasi_massive').': ' . $umkm->name ,[],$umkm);
            $umkm->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function observasi_massive_import($request)
    {
        $import = new \Plugins\BkpmUmkm\Imports\UmkmMassiveImport($request);
        $import->import($request->file('file'));

        $messages = [];
        $error_message = '';
        foreach ($import->failures() as $failure) {
            if (!isset($messages[$failure->row()]['title'])) {
                $messages[$failure->row()] = [
                    'title' => "Row[{$failure->row()}]: <strong>{$failure->values()['nama_usaha']}</strong><br/>",
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
