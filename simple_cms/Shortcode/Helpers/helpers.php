<?php

use Illuminate\Support\HtmlString;

if(!function_exists('clean_shortcodes')){
    function clean_shortcodes($content){
        $content = preg_replace('/<p[^>]*>\[/', '[', $content);;
        $content = preg_replace('/\]<\/p>/', ']', $content);
        $content = preg_replace('/\]<br \/>/', ']', $content);
        $content = preg_replace('/\]<br\/>/', ']', $content);
        $content = preg_replace('/\]<br>/', ']', $content);
        $content = preg_replace('/\] <br \/>/', ']', $content);
        $content = preg_replace('/\] <br\/>/', ']', $content);
        $content = preg_replace('/\] <br>/', ']', $content);
        return $content;
    }
};

if (! function_exists('shortcodes')) {

    /**
     * Render shortcodes.
     *
     * @param string $string
     * @return string|HtmlString
     */
    function shortcodes($string)
    {
        $string = clean_shortcodes(htmlEntityDecode($string));
        return app('shortcodes')->render($string);
    }
}
