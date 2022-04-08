<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 2/22/20 9:40 PM ---------
 */

use SimpleCMS\ActivityLog\ActivityLogger;
use SimpleCMS\ActivityLog\ActivityLogStatus;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog.default_log_name');

        $logStatus = app(ActivityLogStatus::class);

        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName)
            ->setLogStatus($logStatus);
    }
}

if ( ! function_exists('activity_log'))
{

    function activity_log($log_name='default', $group='default',$log,$properties=[], $perfomedOn=null,$user=null) {
        if(auth()->check()){
            $user = auth()->user();
        }else{
            if (is_null($user) OR empty($user)){
                $user = null;
            }
        }
        $log_name = ($log_name != '' ? $log_name : config('activitylog.default_log_name'));
        $request = request();
        $user_requests = [
            'client_ip'     => $request->getClientIp(),
            'user_agent'    => $request->userAgent(),
            'url'           => $request->url(),
            'host'          => $request->getHost(),
            'scheme'        => $request->getScheme(),
            'uri'           => $request->getUri(),
            'method'        => $request->method(),
            'fingerprint'   => $request->fingerprint(),
            'route_name'    => $request->route()->getName()
        ];
        return activity($log_name)
            ->onGroup($group)
            ->performedOn($perfomedOn)
            ->causedBy($user)
            ->withProperties($properties)
            ->withUserRequests($user_requests)
            ->log(trim($log));
    }
}
