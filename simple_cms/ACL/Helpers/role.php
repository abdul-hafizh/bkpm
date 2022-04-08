<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 06/02/20
 * Time: 14:50
 */

define('THIS_CLIENT', 4);
define('LOG_GROUPS', 'LOG_GROUPS');
define('LOG_ROLES', 'LOG_ROLES');

if ( ! function_exists('clearCachePermissions') )
{
    function clearCachePermissions($role_id='')
    {
        if(auth()->check()) {
            if (empty($role_id)){
                $role_id = auth()->user()->role_id;
            }
            return \Cache::forget('RolePermissions.'.$role_id);
        }
        return null;
    }
}

if ( ! function_exists('getCachePermissions') )
{
    function getCachePermissions($role_id='')
    {
        if ( ! empty($role_id) )
        {
            $key = 'RolePermissions.' . $role_id;
            if ( !\Cache::has($key) ) {
                \Cache::rememberForever($key, function () use ($role_id) {
                    $permission = \SimpleCMS\ACL\Models\RoleModel::findOrFail($role_id);
                    return $permission->permissions;
                });
            }
            return \Cache::get($key);
        }
        if (auth()->check()) {
            $key = 'RolePermissions.' . auth()->user()->role_id;
            if ( !\Cache::has($key) ) {
                \Cache::rememberForever($key, function () {
                    return auth()->user()->role->permissions;
                });
            }
            return \Cache::get($key);
        }
        return null;
    }
}

if( ! function_exists('hasRoutePermission') )
{
    function hasRoutePermission($routeName)
    {
        $rolesPermissions = explode(',', getCachePermissions());
        if (is_array($routeName)){
            $routeName = array_unique($routeName);
            $compare = array_intersect($routeName,$rolesPermissions);
            return count($compare);
        }
        return in_array($routeName,$rolesPermissions);
    }
}
