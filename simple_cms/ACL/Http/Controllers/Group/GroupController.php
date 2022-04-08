<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/23/20 1:26 AM ---------
 */

namespace SimpleCMS\ACL\Http\Controllers\Group;

use Illuminate\Http\Request;
use SimpleCMS\ACL\DataTables\GroupDataTable;
use SimpleCMS\ACL\Http\Requests\GroupRequest;
use SimpleCMS\ACL\Models\GroupModel;
use SimpleCMS\ACL\Services\GroupService;
use SimpleCMS\Core\Http\Controllers\Controller;

class GroupController extends Controller
{
    public function index(GroupDataTable $groupDataTable)
    {
        return $groupDataTable->render('acl::group.index');
    }

    public function add(Request $request)
    {
        $params['group'] = new GroupModel();
        $params['title'] = 'Add';
        return view('acl::group._form')->with($params);
    }

    public function edit(Request $request,$id)
    {
        $id = encrypt_decrypt($id,2);
        $params['group'] = GroupModel::findOrFail($id);
        $params['title'] = 'Edit';
        return view('acl::group._form')->with($params);
    }

    public function save_update(GroupRequest $request)
    {
        return responseSuccess(GroupService::save_update($request));
    }

    public function soft_delete(Request $request)
    {
        return responseSuccess(GroupService::delete($request));
    }

    public function force_delete(Request $request)
    {
        return responseSuccess(GroupService::delete($request, true));
    }
    public function restore(Request $request)
    {
        return responseSuccess(GroupService::restore($request));
    }
}