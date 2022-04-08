<?php

namespace SimpleCMS\ACL\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\ACL\DataTables\UserDataTable;
use SimpleCMS\ACL\Http\Requests\UserImportRequest;
use SimpleCMS\ACL\Http\Requests\UserRequest;
use SimpleCMS\ACL\Http\Requests\UpdatePasswordRequest;
use SimpleCMS\ACL\Http\Requests\UpdateProfileRequest;
use SimpleCMS\ACL\Models\GroupModel;
use SimpleCMS\ACL\Models\RoleModel;
use SimpleCMS\ACL\Models\User;
use SimpleCMS\ACL\Services\ProfileService;
use SimpleCMS\ACL\Services\UserService;
use SimpleCMS\Core\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $roles, $groups;

    public function __construct()
    {
        if (auth()->check()) {
            $this->roles = RoleModel::where(function ($q) {
                if (auth()->user()->role_id > 1) {
                    $q->where('id', '>', 1);
                }
            })->cursor();

            $this->groups = GroupModel::where(function ($q) {
                if (auth()->user()->group_id > 1) {
                    $q->where('id', '>', 1);
                }
            })->cursor();
        }
    }

    /**
     * Display a listing of the resource.
     * @param UserDataTable $userDataTable
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('acl::user.index');
    }

    public function add(Request $request)
    {
        $params['user'] = new User();
        $params['groups'] = $this->groups;
        $params['roles'] = $this->roles;
        $params['title'] = 'Add';
        return view('acl::user._form')->with($params);
    }

    public function edit(Request $request,$id)
    {
        $id = encrypt_decrypt($id,2);
        $params['user'] = User::findOrFail($id);
        $params['groups'] = $this->groups;
        $params['roles'] = $this->roles;
        $params['title'] = 'Edit';
        return view('acl::user._form')->with($params);
    }

    public function save_update(UserRequest $request)
    {
        return responseSuccess(UserService::save_update($request));
    }

    public function soft_delete(Request $request)
    {
        return responseSuccess(UserService::delete($request));
    }

    public function force_delete(Request $request)
    {
        return responseSuccess(UserService::delete($request, true));
    }
    public function restore(Request $request)
    {
        return responseSuccess(UserService::restore($request));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function profile(Request $request)
    {
        return view('acl::user.profile');
    }
    public function update_profile(UpdateProfileRequest $request)
    {
        return responseSuccess(ProfileService::update_profile($request));
    }

    public function password(Request $request)
    {
        return view('acl::user.password');
    }
    public function update_password(UpdatePasswordRequest $request)
    {
        return responseSuccess(ProfileService::update_password($request));
    }
    public function import(UserImportRequest $request)
    {
        \Excel::import(new \SimpleCMS\ACL\Imports\UsersImport, $request->file('file'));
        return responseSuccess(responseMessage('Import user success'));
    }

}
