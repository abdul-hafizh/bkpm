<?php

namespace SimpleCMS\Translation\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class CookieMiddleware
{

    /**
     * Handle an incoming request.
     *
     *  @param  \Illuminate\Http\Request  $request
     *  @param  \Closure  $next
     *  @return mixed
     */
    public function handle($request, Closure $next)
    {
        $cookie_locale = $request->cookie('locale');
        $set_language = false;
        $set_from_url = false;

        if (!$cookie_locale){
            $set_language = true;
            $cookie_locale = simple_cms_setting('locale', app('config')->get('app.locale'));
        }

        if ($request->get('locale') && !empty(trim($request->get('locale')))){
            $available_locales = simple_cms_setting('available_locales', app('config')->get('translator.available_locales'));
            if (in_array(trim($request->get('locale')), $available_locales))
            {
                $cookie_locale = trim($request->get('locale'));
            }else{
                $cookie_locale = simple_cms_setting('locale', app('config')->get('app.locale'));
            }
            $set_language = true;
            $set_from_url = true;
        }

        if (!$request->hasSession() OR ($request->hasSession() && $request->session()->get('simple_cms.translation.locale') !== $cookie_locale)) {
            $request->session()->put('simple_cms.translation.locale', $cookie_locale);
        }

        $response = $next($request);

        if ($set_language){
            /*$domain = simple_cms_setting('site_url');
            $domain = str_replace(['http://', 'https://', ''], '', $domain);
            $secure = simple_cms_setting('force_https');*/
            $response->withCookie(cookie()->forever('locale', $cookie_locale));
        }

        /*if ($set_from_url)
        {
            return $this->removeFromQueryAndRedirect($request, 'locale');
        }*/
        return $response;
    }

    /**
     * Remove and make redirection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string                    $parameter
     * @return mixed
     */
    public function removeFromQueryAndRedirect($request, string $parameter)
    {
        $request->query->remove($parameter);
        return redirect()->to($request->fullUrlWithQuery([]));
    }
}
