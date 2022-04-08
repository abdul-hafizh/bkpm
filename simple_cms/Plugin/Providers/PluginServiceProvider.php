<?php

namespace SimpleCMS\Plugin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\Plugin\Repository;

class PluginServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     */
    protected $defer = false;


    /**
     * @var array
     */
    protected $commands = [
        \SimpleCMS\Plugin\Commands\MakePluginCommand::class,
        \SimpleCMS\Plugin\Commands\EnablePluginCommand::class,
        \SimpleCMS\Plugin\Commands\DisablePluginCommand::class,
        \SimpleCMS\Plugin\Commands\MakePluginMigrationCommand::class,
        \SimpleCMS\Plugin\Commands\MakePluginModelCommand::class,
        \SimpleCMS\Plugin\Commands\PluginMigrateCommand::class,
        \SimpleCMS\Plugin\Commands\PluginMigrateRollbackCommand::class,
        \SimpleCMS\Plugin\Commands\PluginSeedCommand::class,
        \SimpleCMS\Plugin\Commands\MakePluginRequestCommand::class,
        \SimpleCMS\Plugin\Commands\PluginListCommand::class,
        \SimpleCMS\Plugin\Commands\MakePluginCommandCommand::class,
        \SimpleCMS\Plugin\Commands\MakePluginEventCommand::class,
        \SimpleCMS\Plugin\Commands\PluginUpdateCommand::class
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('plugins', function($app) {
            return new Repository($app, $app['files']);
        });

        $this->commands($this->commands);

        $this->makePluginsFolder();
        $this->app['plugins']->register();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  **/
        CoreSupport::helpers_autoload(module_path('Plugin','Helpers'));

        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Plugin', 'Database/Migrations'));

//        if (!$this->app->runningInConsole()) {
            $this->app->register(RouteServiceProvider::class);
//        }

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
                    module_path('Plugin', 'Config/'.$file_config) => config_path('plugin.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Plugin', 'Config/'.$file_config), ($config=='config' ? 'plugin' : $config)
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
        $viewPath = resource_path('views/simple_cms/plugin');

        $sourcePath = module_path('Plugin', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/plugin';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'plugin');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/plugin');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'plugin');
        } else {
            $this->loadTranslationsFrom(module_path('Plugin', 'Resources/lang'), 'plugin');
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
            app(Factory::class)->load(module_path('Plugin', 'Database/factories'));
        }
    }

    /**
     * create folder plugins in public folder if not exists.
     */
    public function makePluginsFolder()
    {
        $path = public_path('plugins');
        if (!$this->app['files']->exists($path)) {
            $this->app['files']->makeDirectory($path, 0775, true, true);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['plugins'];
    }
}
