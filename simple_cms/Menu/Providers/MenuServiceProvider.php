<?php

namespace SimpleCMS\Menu\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;
use SimpleCMS\Menu\Menu;
use File;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        CoreSupport::helpers_autoload(module_path('Menu','Helpers'));
        \Menu::create(MENU_ADMINLTE3, function($menu){
            $menu->style(MENU_ADMINLTE3);
            $menu->enableOrdering();
        });
        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->registerMenuFile();
        $this->loadMigrationsFrom(module_path('Menu', 'Database/Migrations'));

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

        $this->app->singleton('menu', function ($app) {
            return new Menu($app['view'], $app['config']);
        });
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Menu', \SimpleCMS\Menu\Facades\Menu::class);

    }

    /**
     * Require the menus file if that file is exists.
     */
    public function registerMenuFile()
    {
        if (file_exists($file = module_path('Menu','Supports').'/menus.php')) {
            $this->app['files']->requireOnce($file);
        }

        if (hasModule('Theme') && file_exists($file = app_path('Themes/'. $this->app['theme']->getThemeSlug() .'/Support/menus.php'))) {
            $this->app['files']->requireOnce($file);
        }

        foreach (\Nwidart\Modules\Facades\Module::getOrdered() as $module) {
            if ($module->getName() != 'Menu' && file_exists($file = module_path($module->getName(),'Supports').'/menus.php')){
                $this->app['files']->requireOnce($file);
            }
        }
        if (hasModule('Plugin')) {
            foreach ($this->app['plugins']->getEnabledPlugins() as $plugin) {
                if (file_exists($file = base_path('Plugins/'.$plugin->name.'/Supports/menus.php'))){
                    $this->app['files']->requireOnce($file);
                }
            }
        }

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
                    module_path('Menu', 'Config/'.$file_config) => config_path('menu.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('Menu', 'Config/'.$file_config), ($config=='config' ? 'menu' : $config)
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
        $viewPath = resource_path('views/simple_cms/menu');

        $sourcePath = module_path('Menu', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/menu';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'menu');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/menu');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'menu');
        } else {
            $this->loadTranslationsFrom(module_path('Menu', 'Resources/lang'), 'menu');
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
            app(Factory::class)->load(module_path('Menu', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['menu'];
    }
}
