<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:16 AM ---------
 */

namespace SimpleCMS\ACL\Services;


use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\ACL\Models\RoleModel;

class RoleService
{
    public static function save_update($request)
    {
        $logProperties = [
            'attributes' => [],
            'old' => (!empty($request->input('id')) ? RoleModel::findOrFail((filter($request->input('id'))))->toArray(): [])
        ];
        $role = RoleModel::query()->updateOrCreate(['id'=>filter($request->input('id'))],[
            'slug' => \Str::slug(filter($request->input('name')),''),
            'name' => filter($request->input('name')),
            'description' => filter($request->input('description')),
            'permissions' => implode(',',$request->input('permissions')),
        ]);
        $message = 'Add Roles & Permission success';
        $activity_group = 'add';
        if (filter($request->input('id'))) {
            clearCachePermissions(filter($request->input('id')));
            $message = 'Edit Roles & Permission success';
            $activity_group = 'edit';
        }
        $logProperties['attributes'] = $role->toArray();
        activity_log(LOG_ROLES, $activity_group,'Your '.$message.', <br/>Role Name : <strong>'.$role->name.'</strong>',$logProperties,$role);
        return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.role.index')]);
    }

    public static function delete($request,$force_delete=false)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $role = RoleModel::withTrashed()->find($id);
        if (!$role){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.role.index')]);
        }
        $message = 'Role ' . $role->name . ' trashed.';
        $log = 'Your trashed role : ';
        $logProperties = [];
        if ($force_delete){
            $message = 'Role ' . $role->name . ' permanent delete.';
            $log = 'Your permanent delete Role : ';
            array_push($logProperties,['attributes' => $role->toArray()]);
            RoleModel::withTrashed()->find($id)->forceDelete();
            $activity_group = 'force_delete';
        }else{
            RoleModel::destroy($id);
            $activity_group = 'soft_delete';
        }
        activity_log(LOG_ROLES, $activity_group,$log . '<br/>Name : <strong>'.$role->name.'</strong>',$logProperties,$role);
        return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.role.index')]);
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $role = RoleModel::withTrashed()->find($id);
        if (!$role){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.role.index')]);
        }
        activity_log(LOG_ROLES, 'restore','Your restore role : ' . '<br/>Name : <strong>'.$role->name.'</strong>',[],$role);
        $role->restore();
        return responseMessage('Restore role : ' . $role->name . ' success.', ['redirect' => route('simple_cms.acl.backend.role.index')]);
    }
}
