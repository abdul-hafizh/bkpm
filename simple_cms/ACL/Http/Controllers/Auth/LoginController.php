<?php

namespace SimpleCMS\ACL\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use SimpleCMS\ACL\Events\NewRegisterAccountEvent;
use SimpleCMS\ACL\Http\Requests\LoginRequest;
use SimpleCMS\ACL\Models\User;
use SimpleCMS\ACL\Models\UserServiceModel;
use SimpleCMS\ACL\Services\RegisterService;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $theme;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->theme = \Theme::uses(themeActive())->layout('auth');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        $request = request();
        if ( ($request->has('modal')&&$request->get('modal')) OR $request->ajax() ){
            if (view()->exists('theme_active::views.auth.modal.login')){
                return view('theme_active::views.auth.modal.login');
            }
            return view('acl::auth.modal.login');
        }
        if (view()->exists('theme_active::views.auth.login')){
            return $this->theme->view('auth.login');
        }
        return view('acl::auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $username = 'username';
        if(filter_var(strtolower($request->input($username)), FILTER_VALIDATE_EMAIL)) {
            $username = 'email';
        }
        if ($username == $this->username()){
            $request->merge([$this->username() => $request->input('username')]);
        }
        return $request->only($username, 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        activity_log('LOG_LOGIN', 'login','Your login: <br/><strong>Time:</strong> '. formatDate(date('Y-m-d H:i:s'),1,1,1) .'<br/><strong>IP:</strong> '.$request->ip(),[],\auth()->user());
        $redirect_intended = url('/');
        if(session()->has('url.intended'))
        {
            $redirect_intended = session('url.intended');
        }
        if ($request->ajax()){
            return responseSuccess(responseMessage('Login success.',['redirect'=>$redirect_intended]));
        }
        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended('/');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ["Invalid username or password."],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        activity_log('LOG_LOGOUT', 'logout','Your logout: <br/><strong>Time:</strong> '. formatDate(date('Y-m-d H:i:s'),1,1,1) .'<br/><strong>IP:</strong> '.$request->ip(),[],\auth()->user());
        $this->guard()->logout();

        $request->session()->invalidate();

        if ($request->ajax()){
            return responseSuccess(responseMessage('Logout success.',['redirect'=>url('/')]));
        }
        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /* Socialite */

    /**
     * Handle Social login request
     * @param  \Illuminate\Http\Request  $request
     * @param string $social
     * @return \Illuminate\Http\Response
     */
    public function socialLogin(Request $request, $social)
    {
        return \Socialite::driver($social)->redirect();
    }

    /**
     * Obtain the user information from Social Logged in.
     * @param  \Illuminate\Http\Request  $request
     * @param $social
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $social)
    {
        $userSocial = \Socialite::driver($social)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        $redirect_intended = url('/');
        if(session()->has('url.intended'))
        {
            $redirect_intended = session('url.intended');
        }

        if($user){
            Auth::login($user);
            UserServiceModel::updateOrCreate(['provider_id' => $userSocial->getId(), 'provider' => $social],[
                'user_id'       => \auth()->user()->id,
                'provider_id'   => $userSocial->getId(),
                'provider'      => $social,
                'token'         => $userSocial->token,
                'secret'        => (isset($userSocial->tokenSecret) ? $userSocial->tokenSecret : ''),
                'refresh_token' => (isset($userSocial->refreshToken) ? $userSocial->refreshToken : '')
            ]);
            activity_log('LOG_LOGIN', 'login','Your login: <br/><strong>Time:</strong> '. formatDate(date('Y-m-d H:i:s'),1,1,1) .'<br/><strong>IP:</strong> '.$request->ip().'<br/><strong>Via:</strong> '.ucwords($social),[],\auth()->user());
            if ($request->ajax()){
                return responseSuccess(responseMessage('Login success.',['redirect'=>$redirect_intended]));
            }
            return redirect()->to($redirect_intended);
        }else{
            /* register via social media */
            /* user */
            $username   = $userSocial->getNickname();
            $email      = $userSocial->getEmail();
            $name       = $userSocial->getName();
            if (!$username){
                $username = \Str::slug($name, '_');
            }
            $username = RegisterService::generateSlug($email, $username);

            $data_user = [
                'role_id' => default_user_role(),
                'group_id' => default_user_group(),
                'status' => 1,
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'avatar'    => $userSocial->getAvatar()
            ];
            $path_upload_default = create_path_default($data_user['username'], public_path('users'));
            $data_user['path'] = $path_upload_default;
            $user = User::create($data_user);
            UserServiceModel::updateOrCreate(['provider_id' => $userSocial->getId(), 'provider' => $social],[
                'user_id'       => \auth()->user()->id,
                'provider_id'   => $userSocial->getId(),
                'provider'      => $social,
                'token'         => $userSocial->token,
                'secret'        => (isset($userSocial->tokenSecret) ? $userSocial->tokenSecret : ''),
                'refresh_token' => (isset($userSocial->refreshToken) ? $userSocial->refreshToken : '')
            ]);
            event(new NewRegisterAccountEvent($user));
            Auth::login($user);
            activity_log('LOG_LOGIN', 'register','Your register: <br/><strong>Time:</strong> '. formatDate(date('Y-m-d H:i:s'),1,1,1) .'<br/><strong>IP:</strong> '.$request->ip().'<br/><strong>Via:</strong> '.ucwords($social),[],\auth()->user());
            return redirect()->to($redirect_intended);
        }
    }
}
