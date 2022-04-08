<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 17/10/17
 * Time: 6:14
 */

namespace SimpleCMS\Core\Supports;

use File;

class CoreSupport
{
    public static function helpers_autoload($directory)
    {
        $helpers = app('files')->glob($directory . '/*.php');
        foreach ($helpers as $helper) {
            app('files')->requireOnce($helper);
        }
    }

    public static function providers_autoload($directory,$provider_namespace,$not_allowed_providers)
    {
        $providers = app('files')->glob($directory . '/*.php');
        foreach ($providers as $provider) {
            $provider = str_replace('.php','',$provider);
            $provider = explode('/',$provider);
            $provider = end($provider);
            if( (is_array($not_allowed_providers) && !in_array($provider, $not_allowed_providers)) OR (!is_array($not_allowed_providers) && $provider != $not_allowed_providers)) {
                app()->register($provider_namespace . $provider);
            }
        }
    }
}
