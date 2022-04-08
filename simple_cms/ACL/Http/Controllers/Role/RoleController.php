<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 06/02/20
 * Time: 14:21
 */

namespace SimpleCMS\ACL\Http\Controllers\Role;


use Illuminate\Http\Request;
use SimpleCMS\ACL\DataTables\RoleDataTable;
use SimpleCMS\ACL\Http\Requests\RoleRequest;
use SimpleCMS\ACL\Models\RoleModel;
use SimpleCMS\ACL\Services\RoleService;
use SimpleCMS\Core\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('acl::role.index');
    }

    public function add(Request $request)
    {
        $params['role'] = new RoleModel();
        $params['title'] = 'Add';
        return view('acl::role._form')->with($params);
    }

    public function edit(Request $request,$id)
    {
        $id = encrypt_decrypt($id,2);
        $params['role'] = RoleModel::findOrFail($id);
        $params['title'] = 'Edit';
        return view('acl::role._form')->with($params);
    }

    public function save_update(RoleRequest $request)
    {
        return responseSuccess(RoleService::save_update($request));
    }

    public function soft_delete(Request $request)
    {
        return responseSuccess(RoleService::delete($request));
    }

    public function force_delete(Request $request)
    {
        return responseSuccess(RoleService::delete($request, true));
    }
    public function restore(Request $request)
    {
        return responseSuccess(RoleService::restore($request));
    }
}