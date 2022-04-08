<?php

namespace Plugins\BkpmUmkm\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\BkpmUmkm\Shortcodes\DataTableKemitraanShortcode;
use Plugins\BkpmUmkm\Shortcodes\GrafikFrontendShortcode;

class BkpmUmkmServiceProvider extends ServiceProvider
{
	/**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
        $this->publishAssets();
    }

	/**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/helper.php');
        $this->app['view']->share('bkpmumkm_identifier', app('config')->get('simple_cms.plugins.bkpmumkm.identifier'));
        $this->registerTranslations();
        $this->registerViews();
        if (!$this->app->runningInConsole()) {
            $this->app->register(RouteServiceProvider::class);
        }
        $this->app['files']->requireOnce(__DIR__ . '/../Helpers/dashboard.php');
        $this->app['shortcodes']->add('DataTableKemitraan', DataTableKemitraanShortcode::class);
        $this->app['shortcodes']->add('GrafikFronted', GrafikFrontendShortcode::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $path_config = base_path('Plugins/BkpmUmkm/Config');
        $this->mergeConfigFrom(
            $path_config . '/config.php', 'simple_cms.plugins.bkpmumkm'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->app['view']->addNamespace('simple_cms.plugins.bkpmumkm', base_path('Plugins/BkpmUmkm/Resources/views'));
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->app['translator']->addNamespace('simple_cms.plugins.bkpmumkm', base_path('Plugins/BkpmUmkm/Resources/lang'));
    }

    /**
     * Publish/Link assets to public folder.
     */
    public function publishAssets()
    {
        $link_path = public_path('plugins/bkpmumkm');
        $target_path = base_path('Plugins/BkpmUmkm/Resources/assets');
        if (!$this->app['files']->exists($link_path) && $this->app['files']->exists($target_path)) {
            $this->app->make('files')->link($target_path, $link_path);
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
