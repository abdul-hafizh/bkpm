<?php

namespace SimpleCMS\Wilayah\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;

class WilayahServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('Wilayah','Helpers'));

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Wilayah', 'Database/Migrations'));

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
                    module_path('Wilayah', 'Config/'.$file_config) => config_path('wilayah.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Wilayah', 'Config/'.$file_config), ($config=='config' ? 'wilayah' : $config)
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
        $viewPath = resource_path('views/simple_cms/wilayah');

        $sourcePath = module_path('Wilayah', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/wilayah';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'wilayah');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/wilayah');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'wilayah');
        } else {
            $this->loadTranslationsFrom(module_path('Wilayah', 'Resources/lang'), 'wilayah');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Wilayah', 'Database/factories'));
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
