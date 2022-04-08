<?php

namespace SimpleCMS\ACL\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
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
        $this->middleware('auth');
        $this->theme = \Theme::uses(themeActive())->layout('auth');
    }

    /**
     * Display the password confirmation view.
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirmForm()
    {
        if (view()->exists('theme_active::views.auth.passwords.confirm')){
            return $this->theme->view('auth.passwords.confirm');
        }
        return view('acl::auth.passwords.confirm');
    }

    /**
     * Confirm the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function confirm(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $this->resetPasswordConfirmationTimeout($request);

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->intended(route('simple_cms.acl.auth.login'));
    }

    /**
     * Reset the password confirmation timeout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function resetPasswordConfirmationTimeout(Request $request)
    {
        $request->session()->put('auth.password_confirmed_at', time());
    }

    /**
     * Get the password confirmation validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        $rules = [
            'password' => 'required|password|min:8',
        ];
        $rules = array_merge($rules, apply_filter('simple_cms_acl_add_to_validation_roles_form_confirm_password_add_filter'));
        return $rules;
    }

    /**
     * Get the password confirmation validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        $messages = [
            'password.required' => 'Password required.',
            'password.min' => 'Password min length 8.'
        ];
        $messages = array_merge($messages, apply_filter('simple_cms_acl_add_to_validation_messages_form_confirm_password_add_filter'));
        return $messages;
    }
}
