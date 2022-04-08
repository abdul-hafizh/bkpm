<?php

namespace SimpleCMS\ACL\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use SimpleCMS\ACL\Http\Requests\RegisterRequest;
use SimpleCMS\ACL\Models\User;
use SimpleCMS\ACL\Services\RegisterService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    protected $theme;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme = \Theme::uses(themeActive())->layout('auth');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (!can_register()) {
            return redirect()->route('simple_cms.acl.auth.login');
        }
        if (view()->exists('theme_active::views.auth.register')){
            return $this->theme->view('auth.register');
        }
        return view('acl::auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        if (!can_register()) {
            throw new NotFoundHttpException('Not Found');
        }
        return responseSuccess(RegisterService::register($request));
    }
}
