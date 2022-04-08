<?php namespace SimpleCMS\Theme\Http\Middleware;

use Closure, Theme;

class ThemeLoader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param String $theme
     * @param String $layout
     * @return mixed
     */
    public function handle($request, Closure $next, $theme = null, $layout = null)
    {
        $theme = $theme ?? themeActive();
        if(!is_null($theme) OR $theme != "") Theme::uses($theme);
        if(!is_null($layout) OR $layout != "") Theme::layout($layout);

        return $next($request);

/*
        $response = $next($request);

        $originalContent = $response->getOriginalContent();

        if(!is_string($originalContent)) {
            $view_name = $originalContent->getName();

            $data = $originalContent->getData();
        } else {
            $view_name = $response->exception->getTrace()[0]['args'][0];
        }


        return $theme->scope($view_name, $data)->render();
*/
    }


}
