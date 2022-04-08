<?php

namespace SimpleCMS\FileManager\Http\Controllers;

use SimpleCMS\FileManager\Connectors\Connector;
use SimpleCMS\FileManager\Session\LaravelSession;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SimpleCMS\Core\Http\Controllers\Controller;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Cached\Storage\Memory;
use League\Flysystem\Filesystem;

class FileManagerController extends Controller
{
    protected $package = 'filemanager';

    public function showIndex(Request $request)
    {
        return view($this->package . '::index')
            ->with($this->getViewVars());
    }

    public function showTinyMCE(Request $request)
    {
        $tiny = 5;
        if ($request->has('tiny') && filter($request->get('tiny'))){
            $tiny = filter($request->get('tiny'));
        }
        return view($this->package . '::tinymce'.$tiny)
            ->with($this->getViewVars());
    }

    public function showTinyMCE4(Request $request)
    {
        return view($this->package . '::tinymce4')
            ->with($this->getViewVars());
    }

    public function showTinyMCE5(Request $request)
    {
        return view($this->package . '::tinymce5')
            ->with($this->getViewVars());
    }

    public function showCKeditor4(Request $request)
    {
        return view($this->package . '::ckeditor4')
            ->with($this->getViewVars());
    }

    public function showPopup(Request $request, $input_id)
    {
        return view($this->package . '::standalonepopup')
            ->with($this->getViewVars())
            ->with(compact('input_id'));
    }

    public function showFilePicker(Request $request, $input_id)
    {
        $type = $request->input('type');
        $mimeTypes = implode(',',array_map(function($t){return "'".$t."'";}, explode(',',$type)));
        return view($this->package . '::filepicker')
            ->with($this->getViewVars())
            ->with(compact('input_id','type','mimeTypes'));
    }

    public function showConnector(Request $request)
    {
        $roots = config('filemanager.roots', []);
        if (empty($roots)) {
            $dirs = (array) config('filemanager.dir', []);
            foreach ($dirs as $dir) {
                $roots[] = [
                    'driver' => 'LocalFileSystem', // driver for accessing file system (REQUIRED)
                    'path' => public_path($dir), // path to files (REQUIRED)
                    'URL' => url($dir), // URL to files (REQUIRED)
                    'accessControl' => config('filemanager.access') // filter callback (OPTIONAL)
                ];
            }

            $disks = (array) config('filemanager.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                if ($disk instanceof FilesystemAdapter) {
                    $defaults = [
                        'driver' => 'Flysystem',
                        'filesystem' => $disk->getDriver(),
                        'alias' => $key,
                    ];
                    $roots[] = array_merge($defaults, $root);
                }
            }
        }

        if (app()->bound('session.store')) {
            $sessionStore = app('session.store');
            $session = new LaravelSession($sessionStore);
        } else {
            $session = null;
        }

        $rootOptions = config('filemanager.root_options', []);
        foreach ($roots as $key => $root) {
            $roots[$key] = array_merge($rootOptions, $root);
        }

        $opts = config('filemanager.options', []);
        $opts = array_merge($opts, ['roots' => $roots, 'session' => $session]);

        // run elFinder
        $connector = new Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

    protected function getViewVars()
    {
        $dir = module_asset('filemanager','');
        $locale = str_replace("-",  "_", config('app.locale'));
        if (!file_exists($dir . "/js/i18n/elfinder.$locale.js")) {
            $locale = false;
        }
        $csrf = true;
        $title = 'FileManager - elFinder 2.0';
        $path = trim(request()->get('path'));
        $path = ($path && $path!='' ? ['path'=>$path] : []);
        $url_connector = route('simple_cms.filemanager.backend.connector', $path);

        return compact('dir', 'locale', 'csrf', 'title', 'url_connector');
    }
}
