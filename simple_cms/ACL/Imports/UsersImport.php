<?php


namespace SimpleCMS\ACL\Imports;


use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class UsersImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        // TODO: Implement onRow() method.
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        if (
            (isset($row['group']) && !empty($row['group'])) &&
            (isset($row['role']) && !empty($row['role'])) &&
            (isset($row['name']) && !empty($row['name'])) &&
            (isset($row['email']) && !empty($row['email'])) &&
            (isset($row['password']) && !empty($row['password']))
        ) {
            $data = [
                'group_id' => trim($row['group']),
                'role_id' => trim($row['role']),
                'name' => filter($row['name']),
                'email' => strtolower(trim($row['email'])),
                'password' => bcrypt(trim($row['password'])),
                'status' => 1
            ];
            if (isset($row['id_negara']) && !empty(filter($row['id_negara']))) {
                $data['id_negara'] = filter($row['id_negara']);
            }
            if (isset($row['id_provinsi']) && !empty(trim($row['id_provinsi']))) {
                $data['id_provinsi'] = trim($row['id_provinsi']);
            }
            if (isset($row['id_kabupaten']) && !empty(trim($row['id_kabupaten']))) {
                $data['id_kabupaten'] = trim($row['id_kabupaten']);
            }
            if (isset($row['id_kecamatan']) && !empty(trim($row['id_kecamatan']))) {
                $data['id_kecamatan'] = trim($row['id_kecamatan']);
            }
            if (isset($row['id_desa']) && !empty(trim($row['id_desa']))) {
                $data['id_desa'] = trim($row['id_desa']);
            }
            if (isset($row['username']) && !empty($row['username'])){
                $data['username'] = \Str::slug(trim($row['username']), '_');
            }else {
                $username = $data['email'];
                $username = explode('@', $username);
                $data['username'] = \Str::slug($username[0], '_');
            }

            $data['username'] = \SimpleCMS\ACL\Services\RegisterService::generateSlug($data['email'], $data['username']);

            /* jika group !== 1 */
            if ((int)$data['group_id'] !== 1) {
                /* check by email */
                $hasUser = \SimpleCMS\ACL\Models\User::where('email', $data['email'])->first();
                $logProperties = [
                    'attributes' => [],
                    'old' => []
                ];
                if (!$hasUser) {
                    $path_upload_default = create_path_default($data['username'], public_path('users'));
                    $data['path'] = $path_upload_default;
                    $message = 'Add user by import success';
                    $activity_group = 'add';
                } else {
                    $logProperties['old'] = $hasUser->toArray();
                    $message = 'Edit user by import success';
                    $activity_group = 'edit';
                }
                $user = \SimpleCMS\ACL\Models\User::query()->updateOrCreate(['email' => $data['email']], $data);
                $logProperties['attributes'] = $user->toArray();
                activity_log(LOG_ACCOUNT, $activity_group, 'Your ' . $message . ', <br/>Name : <strong>' . $user->name . '</strong><br/>Email : <strong>' . $user->email . '</strong>', $logProperties, $user);
            }
        }
    }
}
