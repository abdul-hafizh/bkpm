<?php


namespace Plugins\BkpmUmkm\Services;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Plugins\BkpmUmkm\Models\CompanyKbliModel;
use Plugins\BkpmUmkm\Models\CompanyModel;
use Plugins\BkpmUmkm\Models\CompanyStatusModel;

class CompanyService
{
    protected $company_category = CATEGORY_COMPANY;

    public function save_update($request)
    {
        $path_upload ='';
        \DB::beginTransaction();
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $task_id = filter($request->input('task_id'));
            $task_date = filter($request->input('task_date'));
            
            $pic_id = encrypt_decrypt(filter($request->input('pic_id')), 2);
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? CompanyModel::where(['id' => $id, 'category' => $this->company_category])->first()->toArray() : [])
            ];

            if (empty($id)) {
                $task_id = 1;
                $task_date = now();
            }

            $data = [
                'code' => filter($request->input('code')),
                'name' => filter($request->input('name')),
                'npwp' => filter($request->input('npwp')),
                'type' => filter($request->input('type')),
                'directorate' => filter($request->input('directorate')),
                'pmdn_pma' => filter($request->input('pmdn_pma')),
                'nib' => filter($request->input('nib')),
                'email' => \Str::lower(filter($request->input('email'))),
                'telp' => filter($request->input('telp')),
                'fax' => filter($request->input('fax')),
                'id_negara' => filter($request->input('id_negara')),
                'pma_negara_id' => NULL,
                'address' => filter($request->input('address')),
                'postal_code' => filter($request->input('postal_code')),
                'name_director' => filter($request->input('name_director')),
                'email_director' => \Str::lower(filter($request->input('email_director'))),
                'phone_director' => filter($request->input('phone_director')),
                'name_pic' => filter($request->input('name_pic')),
                'email_pic' => \Str::lower(filter($request->input('email_pic'))),
                'phone_pic' => filter($request->input('phone_pic')),
                'logo' => filter($request->input('logo')),
                'about' => filter($request->input('about')),
                'longitude' => filter($request->input('longitude')),
                'latitude' => filter($request->input('latitude')),
                'total_employees' => 0,
                'investment_plan' => 0,
                'update_journal' => $task_date,
                'journal_task' => $task_id,
                'category'  => $this->company_category
            ];

            if ($request->has('pma_negara_id') && !empty($request->input('pma_negara_id')) ){
                $data['pma_negara_id'] = filter($request->input('pma_negara_id'));
            }

            if ($request->has('business_sector_id') && !empty($request->input('business_sector_id')) ){
                $data['business_sector_id'] = filter($request->input('business_sector_id'));
            }
            if ($request->has('date_nib') && !empty($request->input('date_nib')) ) {
                $data['date_nib'] = carbonParseTransFormat(filter($request->input('date_nib')), 'Y-m-d');
            }
            if ($request->has('id_provinsi') && !empty($request->input('id_provinsi')) ) {
                $data['id_provinsi'] = filter($request->input('id_provinsi'));
            }
            if ($request->has('id_kabupaten') && !empty($request->input('id_kabupaten')) ) {
                $data['id_kabupaten'] = filter($request->input('id_kabupaten'));
            }
            if ($request->has('id_kecamatan') && !empty($request->input('id_kecamatan')) ) {
                $data['id_kecamatan'] = filter($request->input('id_kecamatan'));
            }
            if ($request->has('id_desa') && !empty($request->input('id_desa')) ) {
                $data['id_desa'] = filter($request->input('id_desa'));
            }

            if ($request->has('total_employees') && !empty($request->input('total_employees')) ) {
                $data['total_employees'] = filter($request->input('total_employees'));
            }
            if ($request->has('investment_plan') && !empty($request->input('investment_plan')) ) {
                $data['investment_plan'] = str_replace([',', '.'], '', filter($request->input('investment_plan')));
            }

            if ( !empty($request->input('name_pic')) && !empty($request->input('email_pic')) ) {
                $user = [
                    'name' => $data['name_pic'],
                    'mobile_phone' => $data['phone_pic']
                ];

                // if (!$pic_id) {
                //     /* create user */
                //     $username = \Str::slug($data['name_pic'], '_');
                //     $username = \SimpleCMS\ACL\Services\RegisterService::generateSlug($data['email_pic'], $username);
                //     $password = trim($request->input('password'));
                //     $password = (empty($password) ? '1Kileis849Aeik' : $password);
                //     $user['username'] = $username;
                //     $user['password'] = bcrypt($password);
                //     $user['group_id'] = env('GROUP_STAFF', 3);
                //     $user['role_id'] = env('GROUP_STAFF', 3);
                //     $user['email'] = $data['email_pic'];
                //     $user['status'] = 1;
                //     $user = \SimpleCMS\ACL\Models\User::create($user);
                //     $data['user_id'] = $user->id;
                // } else {
                //     \SimpleCMS\ACL\Models\User::where('id', $pic_id)->update($user);
                // }
            }

            if (empty($id) OR ($id && empty($logProperties['old']['path']))) {
                $slug = \Str::slug($data['name'], '-');
                $path_upload_default = create_path_default($slug, public_path("companies/{$this->company_category}"));
                $data['path'] = $path_upload_default;
                $path_upload = $path_upload_default;
            }

            $company = CompanyModel::query()->updateOrCreate(['id' => $id], $data);

            if(empty($id)){
                DB::table('journal_activity')->insert([
                    'company_id' => $company->id,
                    'user_id' => filter($request->input('user_id')),
                    'journal_task_id' => 1,
                    'activity_date' => now(),
                    'jurnal' => 'Registrasi UB',
                    'created_at' => now()
                ]);
            }

            /* KBLI */
            CompanyKbliModel::where('company_id', $company->id)->forceDelete();
            if ($request->has('code_kbli') && $request->input('code_kbli')) {
                foreach ($request->input('code_kbli') as $kbli) {
                    $multi_kbli = [
                        'code_kbli' => $kbli,
                        'company_id' => $company->id
                    ];
                    CompanyKbliModel::updateOrCreate($multi_kbli, $multi_kbli);
                }
            }

            if(empty($id)){
                $company_status = new CompanyStatusModel();
                $company_status->company_id = $company->id;
                $company_status->save();
            }

            $message = ($id ? 'Edit' : 'Add') . ' ' . trans('label.index_company') . ': ' . $company->name;
            $logProperties['attributes'] = $company->toArray();
            $activity_group = 'add';
            if (!empty($id)){
                $activity_group = 'edit';
            }
            activity_log("LOG_COMPANY", $activity_group, $message, $logProperties, $company);

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.company.index')];
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

    public function save_journal($request)
    {
        $path_upload ='';
        \DB::beginTransaction();

        try {
            $id = filter($request->input('company_id'));
            $logProperties = [
                'attributes' => [],
                'old' => ($id ? CompanyModel::where(['id' => $id, 'category' => $this->company_category])->first()->toArray() : [])
            ];

            DB::table('journal_activity')->insert([
                'company_id' => $id,
                'user_id' => filter($request->input('user_id')),
                'journal_task_id' => filter($request->input('task_id')),
                'activity_date' => filter($request->input('activity_date')),
                'jurnal' => filter($request->input('jurnal')),
                'created_at' => filter($request->input('activity_date'))
            ]);

            DB::table('companies')->where('id', $id)->update(array(
                'update_journal' => filter($request->input('activity_date')),
                'journal_task' => filter($request->input('task_id'))
            ));

            $company = '';

            $message = 'Input Journal';
            $logProperties['attributes'] = $company;
            $activity_group = 'add';

            $returnData = ['redirect' => route('simple_cms.plugins.bkpmumkm.backend.company.index')];
            \DB::commit();
            return responseMessage($message . ' Success.', $returnData);

        } catch (\Exception $e) {
            \DB::rollback();
            if($path_upload && is_dir($path_upload)){
                deleteTreeFolder($path_upload);
            }
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }

    public function change_status($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $company_status_id = encrypt_decrypt($request->input('company_status_id'),1);
        $status     = encrypt_decrypt($request->input('status'),1);
        $company = CompanyModel::where(['id' => $id])->first();
        $company_status = CompanyStatusModel::where('id', $company_status_id)->first();
        if ( !$company_status ){
            $company_status = new CompanyStatusModel();
        }
        if($company) {
            $company_status->company_id = $id;
            $company_status->status = $status;
            $company_status->save();

            activity_log("LOG_COMPANY", "change_status.{$company_status->status}", 'Ubah status: ' . trans("label.company_status_{$status}") ,[],$company);
        }
        return responseMessage(trans('label.change_status_success'));
    }

    public function restore($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $company = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category])->first();
        if($company) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $company->user_id)->restore();
            activity_log("LOG_COMPANY", 'restore', 'Restore '.trans('label.index_company').': ' . $company->name ,[],$company);

            $company->restore();
        }
        return responseMessage(trans('core::message.success.restore'));
    }

    public function soft_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $company = CompanyModel::where(['id' => $id, 'category' => $this->company_category])->first();
        if($company) {
            \SimpleCMS\ACL\Models\User::where('id', $company->user_id)->delete();
            activity_log("LOG_COMPANY", 'soft_delete', 'Trashed '.trans('label.index_company').': ' . $company->name ,[],$company);
            $company->delete();
        }
        return responseMessage(trans('core::message.success_trashed'));
    }

    public function force_delete($request)
    {
        $id = encrypt_decrypt($request->input('id'),2);
        $company = CompanyModel::withTrashed()->where(['id' => $id, 'category' => $this->company_category])->first();
        if($company) {
            \SimpleCMS\ACL\Models\User::withTrashed()->where('id', $company->user_id)->forceDelete();
            activity_log("LOG_COMPANY", 'force_delete', 'Permanent delete '.trans('label.index_company').': ' . $company->name ,[],$company);
            $company->forceDelete();
        }
        return responseMessage(trans('core::message.success.permanent_delete'));
    }

    public function import($request)
    {
        $import = new \Plugins\BkpmUmkm\Imports\CompaniesImport($request, CATEGORY_COMPANY);
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
        /*try {
            \Excel::import(new \Plugins\BkpmUmkm\Imports\CompaniesImport($request, CATEGORY_COMPANY), $request->file('file'));
            return responseSuccess(responseMessage(trans('core::message.success.import')));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            dd($failures);
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }*/
    }

    public function assignNewCompanyPeriode()
    {
        $request = request();
        $company_id = encrypt_decrypt($request->input('company_id'), 1);
        $company = CompanyModel::where(['id' => $company_id])->first();
        if (!$company){
            throw new \Exception('Data tidak ditemukan');
        }
        $company_status = new CompanyStatusModel();
        $company_status->company_id = $company->id;
        $company_status->save();
        $year = \Carbon\Carbon::parse($company_status->created_at)->format('Y');
        activity_log("LOG_COMPANY", 'new_assign', "Menambahkan Perusahaan PMDN/PMA Baru di periode <strong>{$year}</strong>" ,[],$company);
        return responseMessage("Menambahkan Perusahaan PMDN/PMA Baru Berhasil.", ['redirect' => route("simple_cms.plugins.bkpmumkm.backend.company.edit", ['id' => encrypt_decrypt($company->id)])]);
    }
}
