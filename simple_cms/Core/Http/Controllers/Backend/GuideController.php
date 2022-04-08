<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 3/19/20, 2:59 PM ---------
 */

namespace SimpleCMS\Core\Http\Controllers\Backend;

use Illuminate\Http\Request;
use SimpleCMS\Core\Http\Controllers\Controller;

class GuideController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(Request $request)
    {
        $params['key_setting'] = "guide_{$this->user->group_id}";
        $params['file'] = simple_cms_setting($params['key_setting']);
        $params['user'] = $this->user;
        $group_name = str_replace([
            'Group', 'group', 'Groups', 'groups',
            'Roles', 'Role', 'roles', 'role',
            'Rules', 'rules', 'Rule', 'rule'
        ], '', $this->user->group->name);
        $params['title']    = trans('label.guide')." {$group_name}";
        $params['is_admin'] = false;
        if (in_array($this->user->group_id, [1, 2])){
            $params['groups'] = \SimpleCMS\ACL\Models\GroupModel::where('id', '<>', 1)->cursor();
            $params['is_admin'] = true;
        }
        return view('core::guide.index')->with($params);
    }
}
