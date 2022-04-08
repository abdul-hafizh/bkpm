<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:22 AM ---------
 */

/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 1/25/20 1:16 AM ---------
 */

namespace SimpleCMS\ACL\Services;

use Illuminate\Database\Eloquent\Collection;
use SimpleCMS\ACL\Models\GroupModel;
use SimpleCMS\ACL\Models\User;

class GroupService
{
    public static function save_update($request)
    {
        $logProperties = [
            'attributes' => [],
            'old' => (!empty($request->input('id')) ? GroupModel::find(filter($request->input('id')))->toArray(): [])
        ];
        $group = GroupModel::query()->updateOrCreate(['id'=>filter($request->input('id'))],[
            'slug' => \Str::slug(filter($request->input('name')),''),
            'name' => filter($request->input('name')),
            'description' => filter($request->input('description'))
        ]);
        $message = 'Add Group success';
        $activity_group = 'add';
        if (filter($request->input('id'))) {
            $message = 'Edit Group success';
            $activity_group = 'edit';
        }
        $logProperties['attributes'] = $group->toArray();
        activity_log(LOG_GROUPS, $activity_group,'Your '.$message.', <br/>Group Name : <strong>'.$group->name.'</strong>',$logProperties,$group);
        return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.group.index')]);
    }

    public static function delete($request,$force_delete=false)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $group = GroupModel::withTrashed()->find($id);
        if (!$group){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.group.index')]);
        }
        $message = 'Group ' . $group->name . ' trashed.';
        $log = 'Your trashed group : ';
        $logProperties = [];
        if ($force_delete){
            $message = 'Group ' . $group->name . ' permanent delete.';
            $log = 'Your permanent delete Group : ';
            array_push($logProperties,['attributes' => $group->toArray()]);
            GroupModel::withTrashed()->find($id)->forceDelete();
            $activity_group = 'force_delete';
        }else{
            GroupModel::destroy($id);
            $activity_group = 'soft_delete';
        }
        activity_log(LOG_GROUPS, $activity_group,$log . '<br/>Name : <strong>'.$group->name.'</strong>',$logProperties,$group);
        return responseMessage($message, ['redirect' => route('simple_cms.acl.backend.group.index')]);
    }

    public static function restore($request)
    {
        $id = encrypt_decrypt(filter($request->input('id')), 2);
        $group = GroupModel::withTrashed()->find($id);
        if (!$group){
            return responseMessage('Success', ['redirect' => route('simple_cms.acl.backend.group.index')]);
        }
        activity_log(LOG_GROUPS, 'restore','Your restore group : ' . '<br/>Name : <strong>'.$group->name.'</strong>',[],$group);
        $group->restore();
        return responseMessage('Restore group : ' . $group->name . ' success.', ['redirect' => route('simple_cms.acl.backend.group.index')]);
    }
}
