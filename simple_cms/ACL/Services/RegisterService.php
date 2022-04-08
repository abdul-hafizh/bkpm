<?php
/**
 *
 * Created By : Whendy
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 13 January 2020 0:08 ---------
 */


namespace SimpleCMS\ACL\Services;


use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use SimpleCMS\ACL\Events\NewRegisterAccountEvent;
use SimpleCMS\ACL\Models\User;

class RegisterService
{
    public static function register($request)
    {
        \DB::beginTransaction();
        $path_upload ='';
        try {
            $name = filter($request->input('name'));
            $email = strtolower(filter($request->input('email')));
            $username = \Str::slug($name,'_');
            $username = self::generateSlug($email, $username);
            $data = [
                'role_id' => default_user_role(),
                'group_id' => default_user_group(),
                'status' => default_user_status(),
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'password' => bcrypt(trim($request->input('password')))
            ];
            $path_upload_default = create_path_default($data['username'],public_path('users'));
            $data['path'] = $path_upload_default;
            $path_upload = $path_upload_default;

            if ( ! account_verify() ){
                $data['email_verified_at'] = Carbon::now();
            }

            $user = User::create($data);
            event(new NewRegisterAccountEvent($user));
            \DB::commit();
            activity_log('LOG_REGISTER_ACCOUNT', 'register','Your register account at '. formatDate(date('Y-m-d H:i:s'),1,1,1),['attributes'=>$user->toArray(),'old'=>''],$user,$user);
            return responseMessage(__('acl::auth.register.success_registered'), ['redirect' => url('/')]);
        }catch (\Exception $e){
            \DB::rollback();
            if($path_upload && is_dir($path_upload)){
                deleteTreeFolder($path_upload);
            }
            \Log::error($e);
            throw new \ErrorException($e->getMessage());
        }
    }

    public static function generateSlug($email, $slug, $count = 0, $original = '')
    {
        $check_slug = User::where('email', '<>', $email)->where('username', $slug)->count();
        $original = (empty($original) ? $slug : $original);
        if ($check_slug) {
            $count += $check_slug;
            $slug = $original . ($count > 0 ? '-' . $count : '');
            return self::generateSlug($email, $slug, $count, $original);
        }
        return $original . ($count > 0 ? '_' . $count : '');
    }
}
