<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 12/11/17
 * Time: 23:05
 */

if( ! function_exists('library_livecode_editor') )
{
    function library_livecode_editor($lib){
        $libs= [
            'css' => module_style('liveeditor', 'jquery-filetree/jqueryFileTree.css'),
            'js' => module_script('liveeditor', 'jquery-filetree/jqueryFileTree.js') . module_script('liveeditor', 'ace/ace.js') . module_script('liveeditor', 'ace/ext-modelist.js') . module_script('liveeditor', 'ace/ext-modelist.js')
        ];
        return $libs[$lib];
    }
}