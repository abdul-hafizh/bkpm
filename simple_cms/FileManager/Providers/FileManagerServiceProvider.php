<?php

namespace SimpleCMS\FileManager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (!defined('ELFINDER_IMG_PARENT_URL')) {
            define('ELFINDER_IMG_PARENT_URL', $this->app['url']->asset('simple-cms/filemanager'));
        }

        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('FileManager','Helpers'));

        $this->registerTranslations();
        $this->registerViews();

//        if (!$this->app->runningInConsole()) {
            $this->app->register(RouteServiceProvider::class);
//        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->app['router']->aliasMiddleware('filemanager', \SimpleCMS\FileManager\Http\Middleware\FileManagerMiddleware::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $configs = $this->app['files']->glob(__DIR__.'/../Config/*.php');
        foreach ($configs as $config) {
            $config = str_replace('.php','',$config);
            $config = explode('/',$config);
            $config = end($config);
            $file_config = $config.'.php';
            if($config=='config'){
                $this->publishes([
                    module_path('FileManager', 'Config/'.$file_config) => config_path('filemanager.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('FileManager', 'Config/'.$file_config), ($config=='config' ? 'filemanager' : $config)
            );
        }
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/simple_cms/filemanager');

        $sourcePath = module_path('FileManager', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/filemanager';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'filemanager');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/filemanager');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'filemanager');
        } else {
            $this->loadTranslationsFrom(module_path('FileManager', 'Resources/lang'), 'filemanager');
        }
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
