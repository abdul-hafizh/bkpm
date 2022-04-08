<?php


namespace Plugins\BkpmUmkm\Services;


use Illuminate\Support\Carbon;
use Plugins\BkpmUmkm\Models\CompanyKbliModel;
use Plugins\BkpmUmkm\Models\CompanyModel;

class UmkmService
{
    protected $company_category = CATEGORY_UMKM;

    public function potensial_save_update($request)
    {
        $path_upload ='';
        \DB::beginTransaction();
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $pic_id = encrypt_decrypt(filter($request->input('pic_id')), 2);
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_POTENSIAL])->first()->toArray() : [])
            ];

            $data = [
                'code' => filter($request->input('code')),
                'name' => filter($request->input('name')),
                'npwp' => filter($request->input('npwp')),
                'type' => filter($request->input('type')),
                'nib' => filter($request->input('nib')),
                'email' => \Str::lower(filter($request->input('email'))),
                'telp' => filter($request->input('telp')),
                'fax' => filter($request->input('fax')),
                'id_negara' => filter($request->input('id_negara')),
                'address' => filter($request->input('address')),
                'postal_code' => filter($request->input('postal_code')),
                'name_director' => filter($request->input('name_director')),
                'email_director' => \Str::lower(filter($request->input('email_director'))),
                'phone_director' => filter($request->input('phone_director')),
                'name_pic' => filter($request->input('name_pic')),
                'email_pic' => \Str::lower(filter($request->input('email_pic'))),
                'phone_pic' => filter($request->input('phone_pic')),
                'infrastructure' => filter($request->input('infrastructure')),
                'about' => filter($request->input('about')),
                'longitude' => filter($request->input('longitude')),
                'latitude' => filter($request->input('latitude')),
                'total_employees' => 0,
                'net_worth' => 0,
                'omset_every_year' => 0,
                'estimated_venture_capital' => 0,
                'category' => $this->company_category,
                'status' => 1
            ];
            if ($request->has('business_sector_id') && $request->input('business_sector_id')) {
                $data['business_sector_id'] = filter($request->input('business_sector_id'));
            }
            if ($request->has('date_nib') && $request->input('date_nib')) {
                $data['date_nib'] = carbonParseTransFormat(filter($request->input('date_nib')), 'Y-m-d');
            }
            if ($request->has('id_provinsi') && $request->input('id_provinsi')) {
                $data['id_provinsi'] = filter($request->input('id_provinsi'));
            }
            if ($request->has('id_kabupaten') && $request->input('id_kabupaten')) {
                $data['id_kabupaten'] = filter($request->input('id_kabupaten'));
            }
            if ($request->has('id_kecamatan') && $request->input('id_kecamatan')) {
                $data['id_kecamatan'] = filter($request->input('id_kecamatan'));
            }
            if ($request->has('id_desa') && $request->input('id_desa')) {
                $data['id_desa'] = filter($request->input('id_desa'));
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
            if ($request->has('estimated_venture_capital') && $request->input('estimated_venture_capital')) {
                $data['estimated_venture_capital'] = str_replace([',', '.'], '', filter($request->input('estimated_venture_capital')));
            }

            $user = [
                'name' => $data['name_pic'],
                'mobile_phone' => $data['phone_pic']
            ];

            if (!$pic_id) {
                /* create user */
                $username = \Str::slug($data['name_pic'], '_');
                $username = \SimpleCMS\ACL\Services\RegisterService::generateSlug($data['email_pic'], $username);
                $user['username'] = $username;
                $user['password'] = bcrypt(trim($request->input('password')));
                $user['group_id'] = env('GROUP_USER', 4);
                $user['role_id'] = env('GROUP_USER', 4);
                $user['email'] = $data['email_pic'];
                $user['status'] = 1;
                $user = \SimpleCMS\ACL\Models\User::create($user);
                $data['user_id'] = $user->id;
            } else {
                \SimpleCMS\ACL\Models\User::where('id', $pic_id)->update($user);
            }

            if (empty($id) OR ($id && empty($logProperties['old']['path']))) {
                $slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/{$this->company_category}"));
                $data['path'] = $path_upload_default;
                $path_upload = $path_upload_default;
            }

            $umkm = CompanyModel::query()->updateOrCreate(['id' => $id], $data);

            /* KBLI */
            CompanyKbliModel::where('company_id', $umkm->id)->forceDelete();
            if ($request->has('code_kbli') && $request->input('code_kbli')) {
                foreach ($request->input('code_kbli') as $kbli) {
                    $multi_kbli = [
                        'code_kbli' => $kbli,
                        'company_id' => $umkm->id
                    ];
                    CompanyKbliModel::updateOrCreate($multi_kbli, $multi_kbli);
                }
            }

            $message = ($id ? 'Edit' : 'Add') . ' ' . trans('label.umkm_potensial') . ': ' . $umkm->name;
            $logProperties['attributes'] = $umkm->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }
            activity_log("LOG_UMKM", $activity_group, $message, $logProperties, $umkm);

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.umkm.potensial.index')];
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

    public function potensial_restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_POTENSIAL])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $umkm->user_id)->restore();
            activity_log("LOG_UMKM", 'restore', 'Restore '.trans('label.umkm_potensial').': ' . $umkm->name ,[],$umkm);

            $umkm->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function potensial_soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_POTENSIAL])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::where('id', $umkm->user_id)->delete();
            activity_log("LOG_UMKM", 'soft_delete', 'Trashed '.trans('label.umkm_potensial').': ' . $umkm->name ,[],$umkm);
            $umkm->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function potensial_force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_POTENSIAL])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $umkm->user_id)->forceDelete();
            activity_log("LOG_UMKM", 'force_delete', 'Permanent delete '.trans('label.umkm_potensial').': ' . $umkm->name ,[],$umkm);
            $umkm->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function potensial_import($request)
    {
        $import = new \Plugins\BkpmUmkm\Imports\CompaniesImport($request, CATEGORY_UMKM);
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

    /* Observasi */
    public function observasi_save_update($request)
    {
        $path_upload ='';
        \DB::beginTransaction();
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->first()->toArray() : [])
            ];

            $data = [
                'name' => filter($request->input('name')),
                'id_negara' => filter($request->input('id_negara')),
                'address' => filter($request->input('address')),
                'postal_code' => filter($request->input('postal_code')),
                'name_director' => filter($request->input('name_director')),
                'about' => filter($request->input('about')),
                'status' => UMKM_OBSERVASI,
                // 'surveyor_observasi_id' => trim($request->input('surveyor_observasi_id')),
                'category' => $this->company_category
            ];
            if ($request->has('id_provinsi') && $request->input('id_provinsi')) {
                $data['id_provinsi'] = filter($request->input('id_provinsi'));
            }
            if ($request->has('id_kabupaten') && $request->input('id_kabupaten')) {
                $data['id_kabupaten'] = filter($request->input('id_kabupaten'));
            }
            if ($request->has('id_kecamatan') && $request->input('id_kecamatan')) {
                $data['id_kecamatan'] = filter($request->input('id_kecamatan'));
            }
            if ($request->has('id_desa') && $request->input('id_desa')) {
                $data['id_desa'] = filter($request->input('id_desa'));
            }

            if (empty($id) OR ($id && empty($logProperties['old']['path']))) {
                $slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/{$this->company_category}"));
                $data['path'] = $path_upload_default;
                $path_upload = $path_upload_default;
            }

            $umkm = CompanyModel::query()->updateOrCreate(['id' => $id], $data);
            $message = ($id ? 'Edit' : 'Add') . ' ' . trans('label.umkm_observasi') . ': ' . $umkm->name;
            $logProperties['attributes'] = $umkm->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }
            activity_log("LOG_UMKM", $activity_group, $message, $logProperties, $umkm);

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.umkm.observasi.index')];
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

    public function observasi_restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $umkm->user_id)->restore();
            activity_log("LOG_UMKM", 'restore', 'Restore '.trans('label.umkm_observasi').': ' . $umkm->name ,[],$umkm);

            $umkm->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function observasi_soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::where('id', $umkm->user_id)->delete();
            activity_log("LOG_UMKM", 'soft_delete', 'Trashed '.trans('label.umkm_observasi').': ' . $umkm->name ,[],$umkm);
            $umkm->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function observasi_force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $umkm = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category, 'status' => UMKM_OBSERVASI])->first();
        if($umkm) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $umkm->user_id)->forceDelete();
            activity_log("LOG_UMKM", 'force_delete', 'Permanent delete '.trans('label.umkm_observasi').': ' . $umkm->name ,[],$umkm);
            $umkm->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function observasi_import($request)
    {
        $import = new \Plugins\BkpmUmkm\Imports\UmkmObservasiImport($request);
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
