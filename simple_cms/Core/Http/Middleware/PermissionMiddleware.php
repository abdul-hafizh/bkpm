<?php

namespace SimpleCMS\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = $request->route();
        if(Auth::check()) {
            $user = \auth()->user();
            if( (empty($user->id_provinsi) && empty($user->id_kabupaten) ) && !in_array($route->getName(),['simple_cms.acl.backend.user.profile', 'simple_cms.acl.backend.user.update_profile', 'simple_cms.acl.backend.user.password', 'simple_cms.acl.backend.user.update_password']) && !in_array($user->group_id, [GROUP_SUPER_ADMIN, GROUP_ADMIN]) ){
                return redirect()->route('simple_cms.acl.backend.user.profile');
            }
            if (!hasRoutePermission($route->getName())) {
                if ($request->ajax() or $request->segment(1) == 'api') {
                    return response()->json(['status' => 'error', 'code' => 401, 'body' => ['message' => __('core::message.error.authorization')]], 401);
                }
                return response()->view(errorPage('401'), ['message' => __('core::message.error.authorization'), 'code' => 401, 'exceptions' => ''], 401);
            }
        }else{
            if ($request->ajax() or $request->segment(1) == 'api' ) {
                return response()->json(['status' => 'error', 'code' => 401, 'body' => __('core::message.error.authorization') . ' Please Login'], 401);
            }
            return redirect()->route('simple_cms.acl.auth.login');
        }
        return $next($request);
    }
}
