<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:16 AM ---------
 */

namespace SimpleCMS\ACL\Services;

use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\ACL\Models\User;

class UserService
{
    public static function save_update($request)
    {
        $path_upload ='';
        try {
            $id = encrypt_decrypt(filter($request->input('id')), 2);
            $logProperties = [
                'attributes' => [],
                'old' => (!empty($id) ? User::findOrFail($id)->toArray(): [])
            ];
            $email = strtolower(filter($request->input('email')));
            $username = \Str::slug(filter($request->input('username')), '_');
            $username = RegisterService::generateSlug($email, $username);
            $data = [
                'group_id' => filter($request->input('group_id')),
                'role_id' => filter($request->input('role_id')),
                'status' => (filter($request->input('status')) != '' ? filter($request->input('status')) : 0),
                'username' => $username,
                'name' => filter($request->input('name')),
                'email' => $email,
                'id_negara' => filter($request->input('id_negara')),
                'id_provinsi' => filter($request->input('id_provinsi')),
                'id_kabupaten' => filter($request->input('id_kabupaten')),
                'id_kecamatan' => filter($request->input('id_kecamatan')),
                'id_desa' => filter($request->input('id_desa'))
            ];
            $message = 'Edit user success';
            $activity_group = 'edit';
            if (empty($id)) {
                $path_upload_default = create_path_default($data['username'], public_path('users'));
                $data['path'] = $path_upload_default;
                $path_upload = $path_upload_default;
                $data['password'] = bcrypt(trim($request->input('password')));
                $message = 'Add user success';
                $activity_group = 'add';
            }

            if ($request->has('password') && $request->input('password')){
                $data['password'] = bcrypt(trim($request->input('password')));
            }

            if ( ! account_verify() ){
                $data['email_verified_at'] = date('Y-m-d H:i:s');
            }
            $user = User::query()->updateOrCreate(['id'=>$id],$data);
            $logProperties['attributes'] = $user->toArray();
            activity_log(LOG_ACCOUNT, $activity_group,'Your '.$message.', <br/>Name : <strong>'.$user->name.'</strong><br/>Email : <strong>'.$user->email.'</strong>',$logProperties,$user);

            event(new \SimpleCMS\ACL\Events\NewRegisterAccountEvent($user));

            return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.user.index')]);
        }catch (\Exception $e){
            if($path_upload && is_dir($path_upload)){
                deleteTreeFolder($path_upload);
            }
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function delete($request,$force_delete=false)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $user = User::withTrashed()->find($id);
        if (!$user){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.user.index')]);
        }
        $message = 'User ' . $user->name . ' trashed.';
        $log = 'Your trashed user : ';
        $logProperties = [];
        if ($force_delete){
            $message = 'User ' . $user->name . ' permanent delete.';
            if ( $user->path && \File::exists(public_path($user->path))){
                \File::deleteDirectory(public_path($user->path));
            }
            $log = 'Your permanent delete user : ';
            array_push($logProperties,['attributes' => $user->toArray()]);
            User::withTrashed()->find($id)->forceDelete();
            $activity_group = 'force_delete';
        }else{
            User::destroy($id);
            $activity_group = 'soft_delete';
        }
        activity_log(LOG_ACCOUNT, $activity_group,$log . '<br/>Name : <strong>'.$user->name.'</strong><br/>Email : <strong>'.$user->email.'</strong>',$logProperties,$user);
        return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.user.index')]);
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $user = User::withTrashed()->find($id);
        if (!$user){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.user.index')]);
        }
        activity_log(LOG_ACCOUNT, 'restore','Your restore user : ' . '<br/>Name : <strong>'.$user->name.'</strong><br/>Email : <strong>'.$user->email.'</strong>',[],$user);
        $user->restore();
        return responseMessage('Restore user : ' . $user->name . ' success.', ['redirect' => route('simple_cms.acl.backend.user.index')]);
    }
}
