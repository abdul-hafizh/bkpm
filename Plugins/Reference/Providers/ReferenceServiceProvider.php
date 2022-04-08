<?php

namespace Plugins\Reference\Providers;

use Illuminate\Support\ServiceProvider;

class ReferenceServiceProvider extends ServiceProvider
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
        $this->registerTranslations();
        $this->registerViews();
        if (!$this->app->runningInConsole()) {
            $this->app->register(\Plugins\Reference\Providers\RouteServiceProvider::class);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $path_config = base_path('Plugins/Reference/Config');
        $this->mergeConfigFrom(
            $path_config . '/config.php', 'simple_cms.plugins.reference'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->app['view']->addNamespace('simple_cms.plugins.reference', base_path('Plugins/Reference/Resources/views'));
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->app['translator']->addNamespace('simple_cms.plugins.reference', base_path('Plugins/Reference/Resources/lang'));
    }

    /**
     * Publish/Link assets to public folder.
     */
    public function publishAssets()
    {
        $link_path = public_path('plugins/reference');
        $target_path = base_path('Plugins/Reference/Resources/assets');
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
