<?php
/**
 * Created by PhpStorm.
 * User: whendy
 * Date: 23/01/20
 * Time: 4:27
 */

namespace SimpleCMS\Theme\Http\Controllers\Backend;


use Illuminate\Http\Request;
use SimpleCMS\Core\Http\Controllers\Controller;

class ThemeController extends Controller
{
    protected $theme;
    protected $pathTheme;
    protected $files;
    protected $configFile = 'theme.json';
    protected $theme_active;


    public function __construct()
    {
        $pathTheme = base_path('Themes');
        $this->files = app('files');
        $this->pathTheme = $this->files->directories($pathTheme);
        $this->theme_active = themeActive();
        $this->theme = \Theme::uses($this->theme_active);
    }

    public function index(Request $request)
    {
        $params['theme_active'] = $this->theme_active;
        $themes = [];
        $index = 1;
        foreach ($this->pathTheme as $theme) {
            if ($this->files->isFile($theme.'/'.$this->configFile)){
                $content            = $this->files->get($theme.'/'.$this->configFile);
                $content            = (isJson($content) ? json_decode($content) : new Object());
                $content->path      = $theme;
                $content->preview   = ($this->files->isFile($theme.'/assets/images/preview.png') ? asset('themes/'.$content->slug.'/images/preview.png') : thumb_image());
                $first = ($content->slug == $params['theme_active'] ? 0 : $index);
                $themes[$first]           = $content;
                $index++;
            }
        }
        ksort($themes);
        $params['themes'] = $themes;
        return \Theme::of('theme::backend.index', $params)->content();
    }

    public function option(Request $request)
    {
        if (view()->exists('theme_active::views.backend.theme_options')) {
            return view('theme_active::views.backend.theme_options');
        }
        return redirect()->route('simple_cms.setting.backend.index');
    }
}
