<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:16 AM ---------
 */

/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 25/01/20
 * Time: 1:16
 */

namespace SimpleCMS\ACL\Services;


use Illuminate\Support\Facades\Hash;
use SimpleCMS\ACL\Events\PasswordResetEvent;

class ProfileService
{
    public static function update_profile($request)
    {
        $logProperties = [
            'attributes' => [],
            'old' => $request->user()->toArray()
        ];
        $update = [
            'name' => filter($request->input('name')),
//            'username' => filter($request->input('username')),
            'email' => strtolower(trim($request->input('email'))),
            'avatar' => trim($request->input('avatar')),
            'mobile_phone' => filter($request->input('mobile_phone')),
            'address' => filter($request->input('address')),
            'postal_code' => filter($request->input('postal_code')),
            'id_negara' => filter($request->input('id_negara')),
            'id_provinsi' => filter($request->input('id_provinsi')),
            'id_kabupaten' => $request->input('id_kabupaten'),
            'id_kecamatan' => $request->input('id_kecamatan'),
            'id_desa' => $request->input('id_desa')
        ];
        $request->user()->update($update);
        $logProperties['attributes'] = $request->user()->toArray();
        activity_log('LOG_UPDATE_PROFILE', 'edit','Your update profile at '. formatDate(date('Y-m-d H:i:s'),1,1,1),$logProperties,$request->user());
        return responseMessage('Update Profile Success');
    }

    public static function update_password($request)
    {
        $update['password'] = Hash::make($request->input('password'));
        $request->user()->update($update);
        activity_log('LOG_CHANGE_PASSWORD', 'update_password','Your change password at '. formatDate(date('Y-m-d H:i:s'),1,1,1),[],$request->user(),$request->user());
        event(new PasswordResetEvent($request->user(),['user_agent' => $request->userAgent() , 'user_ip' => $request->getClientIp() ]));
        return responseMessage('Update Password Success');
    }
}
