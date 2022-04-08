<?php

namespace SimpleCMS\LiveEditor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;

class LiveEditorController extends Controller
{

    public function index(Request $request)
    {
        $path = $request->get('path');
        $active_path = $path;
        switch($path){
            case "root":
            case "env":
                $path = DIRECTORY_SEPARATOR;
                break;
            case "shortcode":
                $path = DIRECTORY_SEPARATOR . 'simple_cms' . DIRECTORY_SEPARATOR . 'Blog' . DIRECTORY_SEPARATOR . 'Shortcodes' . DIRECTORY_SEPARATOR;
                break;
            default:
                $path = DIRECTORY_SEPARATOR . 'Themes' . DIRECTORY_SEPARATOR;
                break;
        }
        return view('liveeditor::backend.index', [
            'no_header' => true,
            'no_padding' => "no-padding",
            'sidebar_mini' => "sidebar-mini sidebar-collapse",
            'active_path' => $active_path,
            'path' => $path
        ]);
    }

    public function get_dir(Request $request)
    {
        try {
            $root = base_path() . DIRECTORY_SEPARATOR;
            $dir = $request->get('dir');
            $postDir = rawurldecode(base_path($dir));

            if (file_exists($postDir)) {
                $files = scandir($postDir);
                $returnDir = substr($postDir, strlen($root));
                natcasesort($files);
                if (count($files) > 2) { // The 2 accounts for . and ..
                    echo "<ul class='jqueryFileTree'>";
                    foreach ($files as $file) {
                        $htmlRel = htmlentities($returnDir . $file);
                        $htmlName = htmlentities($file);
                        $ext = preg_replace('/^.*\./', '', $file);
                        if (file_exists($postDir . $file) && $file != '.' && $file != '..') {
                            if ($dir != '/') {
                                if (is_dir($postDir . $file) && !in_array($file, config('liveeditor.not_allowed_paths_or_files'))) {
                                    echo "<li class='directory collapsed'><a rel='" . $htmlRel . "/'>" . $htmlName . "</a></li>";
                                } else {
                                    if (!in_array($file, config('liveeditor.not_allowed_paths_or_files'))) {
                                        echo "<li class='file ext_{$ext}'><a rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
                                    }
                                }
                            }else{
                                if (in_array($file, config('liveeditor.allowed_roots'))) {
                                    if (is_dir($postDir . $file)  && !in_array($file, config('liveeditor.not_allowed_paths_or_files'))) {
                                        echo "<li class='directory collapsed'><a rel='" . $htmlRel . "/'>" . $htmlName . "</a></li>";
                                    } else {
                                        if (!in_array($file, config('liveeditor.not_allowed_paths_or_files'))) {
                                            echo "<li class='file ext_{$ext}'><a rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                    echo "</ul>";
                }
            }
        }catch (\Exception $e){
            \Log::error($e);
            throw new \Exception($e->getMessage());
        }
    }


    public function get_file(Request $request)
    {
        try {
            $filepath = $request->input('filepath');
            $data = \File::get(base_path($filepath));
            return responseSuccess(responseMessage('Success',['data' => $data, '_token' => csrf_token()]));
        }catch (\Exception $e){
            \Log::error($e);
            return responseError(responseMessage($e->getMessage(),['_token' => csrf_token()]));
        }
    }

    public function save_file(Request $request)
    {
        $get_cwd = '';
        try {
            $filepath = $request->input('filepath');
            $filedata = $request->input('filedata');
            $filepath = ltrim($filepath, '/');
            $filepath = base_path($filepath);
            \File::put($filepath,$filedata);
            return responseSuccess(responseMessage('Success',['success'=>true,'data' => $filedata, '_token' => csrf_token()]));
        }catch (\Exception $e){
            return responseError(responseMessage($e->getMessage(),['success'=>false,'_token' => csrf_token(),'cwd'=>$get_cwd]));
        }
    }
}
