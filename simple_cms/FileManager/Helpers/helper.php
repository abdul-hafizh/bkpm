<?php

if ( ! function_exists('library_tinymce') )
{
    /*
     * @param string css|js $lib
     * */
    function library_tinymce($lib)
    {
        $libs = [
            'css'   => '',
            'js'    => module_script('core', 'plugins/tinymce/5.4.1/tinymce.min.js')
        ];
        return $libs[$lib];
    }
}

if ( ! function_exists('filemanager_standalonepopup') )
{
    function filemanager_standalonepopup()
    {
        return module_script('filemanager', 'js/standalonepopup.min.js');
    }
}
