<?php
namespace SimpleCMS\Core\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $account_verify = account_verify();
        if ( !in_array($request->route()->getName(), [
                'simple_cms.acl.auth.verification.notice',
                'simple_cms.acl.auth.verification.verify',
                'simple_cms.acl.auth.verification.resend'
            ]) &&
            $account_verify &&
            ($request->user() instanceof MustVerifyEmail &&
                ! $request->user()->hasVerifiedEmail())) {
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route($redirectToRoute ?: 'simple_cms.acl.auth.verification.notice');
        }

        return $next($request);
    }
}
