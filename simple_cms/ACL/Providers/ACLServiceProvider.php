<?php

namespace SimpleCMS\ACL\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use SimpleCMS\Core\Supports\CoreSupport;

class ACLServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /** This register all Helpers if have  */
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/user.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/role.php');
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/FormSettingAcl.php');

        $this->registerTranslations();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('ACL', 'Database/Migrations'));

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
        $this->app->register(EventServiceProvider::class);
        $this->registerConfig();
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/auth.php');
        if ( class_exists(\Laravel\Socialite\SocialiteServiceProvider::class) ) {
            $this->app->register(\Laravel\Socialite\SocialiteServiceProvider::class);
        }
        $this->app->alias('Socialite', \Laravel\Socialite\Facades\Socialite::class);

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
                    module_path('ACL', 'Config/'.$file_config) => config_path('acl.php'),
                ], 'config');
            }
            $this->mergeConfigFrom(
                module_path('ACL', 'Config/'.$file_config), ($config=='config' ? 'acl' : $config)
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
        $viewPath = resource_path('views/simple_cms/acl');

        $sourcePath = module_path('ACL', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/simple_cms/acl';
        }, $this->app['config']->get('view.paths')), [$sourcePath]), 'acl');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/simple_cms/acl');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'acl');
        } else {
            $this->loadTranslationsFrom(module_path('ACL', 'Resources/lang'), 'acl');
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
            app(Factory::class)->load(module_path('ACL', 'Database/factories'));
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
